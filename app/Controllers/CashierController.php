<?php namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\TableModel;
use App\Models\MenuModel;
use App\Models\CategoryModel;
use App\Models\NotificationModel;
use App\Models\UserModel;

class CashierController extends BaseController
{
    public function index()
    {
        $orderModel = new OrderModel();
        $today = date('Y-m-d');

        // Todays sales from orders created by this cashier
        $data['todays_sales'] = $orderModel
            ->selectSum('total_amount')
            ->where('DATE(created_at)', $today)
            ->where('user_id', session()->get('user_id'))
            ->first()['total_amount'] ?? 0;

        // Todays orders created by this cashier
        $data['todays_orders'] = $orderModel
            ->where('DATE(created_at)', $today)
            ->where('user_id', session()->get('user_id'))
            ->countAllResults();

        return view('cashier/dashboard', $data);
    }

    public function new_order()
    {
        $tableModel = new TableModel();
        $menuModel = new MenuModel();
        $categoryModel = new CategoryModel();
        
        $data['tables'] = $tableModel->where('status', 'Available')->findAll();
        $data['categories'] = $categoryModel->findAll();
        $data['menu_items'] = $menuModel->getMenuItemsWithCategories();
        
        $data['menu_by_category'] = [];
        foreach($data['menu_items'] as $item) {
            $categoryId = $item['category_id'] ?? 'uncategorized';
            $data['menu_by_category'][$categoryId][] = $item;
        }
        
        return view('cashier/create_order', $data);
    }

    public function create_order()
    {
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Validation for items
            $items = $this->request->getPost('items');
            if (empty($items)) {
                 return redirect()->back()->withInput()->with('error', 'Cannot create an empty order.');
            }
            
            $orderType = $this->request->getPost('order_type');
            $tableId = $this->request->getPost('table_id');

            // Server-side validation for table selection
            if ($orderType === 'dine_in' && empty($tableId)) {
                return redirect()->back()->withInput()->with('error', 'Please select a table for Dine-In orders.');
            }

            $orderModel = new OrderModel();
            $orderItemModel = new OrderItemModel();
            $tableModel = new TableModel();
            
            // Step 1: Create a basic order record, like the guest flow
            $initialOrderData = [
                'user_id'      => session()->get('user_id'),
                'total_amount' => $this->request->getPost('grand_total'),
                'status'       => 'Pending',
                // 'order_type' and 'table_id' are omitted for now
            ];

            $orderModel->insert($initialOrderData);
            $orderId = $orderModel->getInsertID();
            
            if (!$orderId) {
                $db->transRollback();
                return redirect()->back()->withInput()->with('error', 'Database error: Could not create the order.');
            }

            // Step 2: Add order items
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

            // Step 3: Update the order with type and table info
            $updateData = [
                'order_type' => $orderType,
                'table_id'   => ($orderType === 'dine_in') ? $tableId : null,
            ];
            $orderModel->update($orderId, $updateData);

            // Step 4: Update table status if it's a dine-in order
            if ($orderType === 'dine_in' && $tableId) {
                $tableModel->update($tableId, ['status' => 'Occupied']);
            }

            $db->transComplete();
            $this->createOrderNotification($orderId);
            
            return redirect()->to('/cashier/receipt/' . $orderId)->with('status', 'Order Placed & Payment Complete!');

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

        $itemList = '<ul>';
        foreach ($orderItems as $item) {
            $itemList .= '<li>' . esc($item['item_name']) . ' (Qty: ' . $item['quantity'] . ')</li>';
        }
        $itemList .= '</ul>';

        $message = 'A new order (ID: ' . $orderId . ') has been placed.' . $itemList;

        foreach ($adminsAndChefs as $user) {
            $notificationModel->save([
                'user_id'  => $user['id'],
                'order_id' => $orderId,
                'message'  => $message,
                'is_read'  => 0
            ]);
        }
    }
    
    public function receipt($id)
    {
        $orderModel = new OrderModel();
        $orderItemModel = new OrderItemModel();

        $data['order'] = $orderModel->getOrderDetails($id);
        $data['order_items'] = $orderItemModel->getItemsByOrderId($id);
        $data['back_url'] = '/cashier/dashboard'; // Specific back URL for cashier

        if (empty($data['order'])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('orders/receipt', $data);
    }
}