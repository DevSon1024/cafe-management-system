<?php namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\TableModel;
use App\Models\MenuModel;
use App\Models\CategoryModel;
use App\Models\NotificationModel;
use App\Models\UserModel;

class OrderController extends BaseController
{
    public function index()
    {
        $orderModel = new OrderModel();
        $data['orders'] = $orderModel->getOrdersWithDetails(); // Fetches all orders
        return view('orders/index', $data);
    }

    public function new()
    {
        $tableModel = new TableModel();
        $menuModel = new MenuModel();
        $categoryModel = new CategoryModel();
        
        $data['tables'] = $tableModel->where('status', 'Available')->findAll();
        $data['categories'] = $categoryModel->findAll();
        $data['menu_items'] = $menuModel->getMenuItemsWithCategories();
        
        // Group menu items by category for easier display
        $data['menu_by_category'] = [];
        foreach($data['menu_items'] as $item) {
            $categoryId = $item['category_id'] ?? 'uncategorized';
            $data['menu_by_category'][$categoryId][] = $item;
        }
        
        return view('orders/create', $data);
    }

    public function create()
    {
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $orderModel = new OrderModel();
            $orderItemModel = new OrderItemModel();
            $tableModel = new TableModel();

            $orderData = [
                'table_id'     => $this->request->getPost('table_id'),
                'user_id'      => session()->get('user_id'), // Get user ID from session
                'total_amount' => $this->request->getPost('grand_total'),
                'status'       => 'Pending'
            ];
            $orderModel->insert($orderData);
            $orderId = $orderModel->getInsertID();

            $items = $this->request->getPost('items');
            $quantities = $this->request->getPost('quantities');
            $subtotals = $this->request->getPost('subtotals');

            for ($i = 0; $i < count($items); $i++) {
                $orderItemData = [
                    'order_id' => $orderId,
                    'item_id'  => $items[$i],
                    'quantity' => $quantities[$i],
                    'subtotal' => $subtotals[$i]
                ];
                $orderItemModel->insert($orderItemData);
            }

            // Update table status
            $tableModel->update($this->request->getPost('table_id'), ['status' => 'Occupied']);

            $db->transComplete();
            $this->createOrderNotification($orderId);
            
            // Redirect based on user role
            $redirectURL = (session()->get('role') === 'admin') ? '/admin/orders' : '/user/profile';

            return redirect()->to($redirectURL)->with('status', 'Order Placed Successfully');

        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Failed to place order: ' . $e->getMessage());
        }
    }
    
    public function receipt($id)
    {
        $orderModel = new OrderModel();
        $orderItemModel = new OrderItemModel();

        $data['order'] = $orderModel->getOrderDetails($id);
        $data['order_items'] = $orderItemModel->getItemsByOrderId($id);

        if (empty($data['order'])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // SECURITY CHECK: Ensure a regular user can only see their own order
        if (session()->get('role') === 'user' && session()->get('user_id') != $data['order']['user_id']) {
            return redirect()->to('/user/orders')->with('error', 'You are not authorized to view this order.');
        }
        
        if (session()->get('isLoggedIn') && session()->get('role') === 'admin') {
            $data['back_url'] = '/admin/orders';
        } else {
            $data['back_url'] = '/'; // For guests or any other logged-in user
        }
        
        return view('orders/receipt', $data);
    }
    
    public function complete($id)
    {
        $orderModel = new OrderModel();
        $tableModel = new TableModel();

        $order = $orderModel->find($id);
        if ($order && !empty($order['table_id'])) {
            $tableModel->update($order['table_id'], ['status' => 'Available']);
        }
        $orderModel->update($id, ['status' => 'Completed']);
        
        return redirect()->to('/admin/orders')->with('status', 'Order marked as completed and table is now available.');
    }
    
    public function new_guest_order()
    {
        $menuModel = new MenuModel();
        $categoryModel = new CategoryModel();

        $data['categories'] = $categoryModel->findAll();
        $data['menu_items'] = $menuModel->getMenuItemsWithCategories();

        $data['menu_by_category'] = [];
        foreach($data['menu_items'] as $item) {
            $categoryId = $item['category_id'] ?? 'uncategorized';
            $data['menu_by_category'][$categoryId][] = $item;
        }

        return view('orders/create_guest', $data);
    }

    public function create_guest_order()
    {
        if (empty($this->request->getPost('items'))) {
            return redirect()->back()->with('error', 'Please add at least one item to your order.');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $orderModel = new OrderModel();
            $orderItemModel = new OrderItemModel();

            $orderData = [
                'total_amount' => $this->request->getPost('grand_total'),
                'status'       => 'Pending',
                'order_type'   => 'Take Away' // Set default order type
            ];
            $orderModel->insert($orderData);
            $orderId = $orderModel->getInsertID();

            $items = $this->request->getPost('items');
            $quantities = $this->request->getPost('quantities');
            $subtotals = $this->request->getPost('subtotals');

            for ($i = 0; $i < count($items); $i++) {
                $orderItemData = [
                    'order_id' => $orderId,
                    'item_id'  => $items[$i],
                    'quantity' => $quantities[$i],
                    'subtotal' => $subtotals[$i]
                ];
                $orderItemModel->insert($orderItemData);
            }

            $db->transComplete();
            $this->createOrderNotification($orderId);


            return view('orders/order_type', ['order_id' => $orderId]);

        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Failed to place order: ' . $e->getMessage());
        }
    }

    private function createOrderNotification($orderId)
    {
        $userModel = new UserModel();
        $notificationModel = new NotificationModel();
        $orderItemModel = new OrderItemModel();

        $adminsAndChefs = $userModel->whereIn('role', ['admin', 'chef'])->findAll();
        $orderItems = $orderItemModel->getItemsByOrderId($orderId);

        // A cleaner message for the toast
        $itemNames = array_map(function($item) {
            return esc($item['item_name']) . ' (x' . $item['quantity'] . ')';
        }, $orderItems);

        $message = 'New order #' . $orderId . ' placed. Items: ' . implode(', ', $itemNames);

        foreach ($adminsAndChefs as $user) {
            $notificationModel->save([
                'user_id'  => $user['id'],
                'order_id' => $orderId,
                'message'  => $message,
                'is_read'  => 0
            ]);
        }
    }

    public function process_order_type()
    {
        $orderId = $this->request->getPost('order_id');
        $orderType = $this->request->getPost('order_type');

        $orderModel = new OrderModel();
        $order = $orderModel->find($orderId);

        if ($orderType === 'dine_in') {
            $tableModel = new TableModel();
            $data['tables'] = $tableModel->where('status', 'Available')->findAll();
            $data['order_id'] = $orderId;
            $data['order_type'] = 'dine_in';
            $data['total_amount'] = is_array($order) ? $order['total_amount'] : $order->total_amount;
            return view('orders/payment', $data);
        }

        $data['order_id'] = $orderId;
        $data['order_type'] = 'take_away';
        $data['total_amount'] = is_array($order) ? $order['total_amount'] : $order->total_amount;
        return view('orders/payment', $data);
    }

    public function process_payment()
    {
        $orderId = $this->request->getPost('order_id');
        $orderType = $this->request->getPost('order_type');
        $tableId = $this->request->getPost('table_id');

        $orderModel = new OrderModel();
        $orderItemModel = new OrderItemModel();
        $tableModel = new TableModel();

        $data = [
            'status' => 'Pending',
            'order_type' => $orderType
        ];

        if ($orderType === 'dine_in' && $tableId) {
            $data['table_id'] = $tableId;
            $tableModel->update($tableId, ['status' => 'Occupied']);
        }

        $orderModel->update($orderId, $data);

        $data['order'] = $orderModel->getOrderDetails($orderId);
        $data['order_items'] = $orderItemModel->getItemsByOrderId($orderId);

        return view('orders/receipt_preview', $data);
    }

    public function update_status($id)
    {
        $orderModel = new OrderModel();
        $tableModel = new TableModel();
        $status = $this->request->getPost('status');
        
        $orderModel->update($id, ['status' => $status]);

        if ($status === 'Completed') {
            $order = $orderModel->find($id);
            if ($order && !empty($order['table_id'])) {
                $tableModel->update($order['table_id'], ['status' => 'Available']);
            }
        }

        return redirect()->to('/admin/orders')->with('status', 'Order status updated successfully.');
    }

    public function delete($id = null)
    {
        $orderModel = new OrderModel();
        $orderItemModel = new OrderItemModel();
        $tableModel = new TableModel();

        // Find the order to get the table ID
        $order = $orderModel->find($id);

        // If the order exists and has a table, set the table to "Available"
        if ($order && !empty($order['table_id'])) {
            $tableModel->update($order['table_id'], ['status' => 'Available']);
        }

        $orderItemModel->where('order_id', $id)->delete();
        $orderModel->delete($id);

        return redirect()->to('/admin/orders')->with('status', 'Order Deleted Successfully');
    }
}