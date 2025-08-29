<?php namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\TableModel;
use App\Models\MenuModel;
use App\Models\CategoryModel;

class OrderController extends BaseController
{
    public function index()
    {
        $orderModel = new OrderModel();
        $data['orders'] = $orderModel->getOrdersWithDetails();
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

        return view('orders/receipt', $data);
    }
    
    public function complete($id)
    {
        $orderModel = new OrderModel();
        $tableModel = new TableModel();

        $order = $orderModel->find($id);
        if ($order) {
            $tableModel->update($order['table_id'], ['status' => 'Available']);
            $orderModel->update($id, ['status' => 'Completed']);
        }
        
        // Corrected Redirect Path
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
        // Add this check at the beginning of the method
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

            $db->transComplete();

            return view('orders/order_type', ['order_id' => $orderId]);

        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Failed to place order: ' . $e->getMessage());
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
            $data['total_amount'] = $order['total_amount']; // Corrected line
            return view('orders/payment', $data);
        }

        // For take away, go directly to payment simulation
        $data['order_id'] = $orderId;
        $data['order_type'] = 'take_away';
        $data['total_amount'] = $order['total_amount']; // Corrected line
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
            'status' => 'Completed',
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
}