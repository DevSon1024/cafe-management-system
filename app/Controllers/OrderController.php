<?php namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\TableModel;
use App\Models\MenuModel;

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
        $data['tables'] = $tableModel->where('status', 'Available')->findAll();
        $data['menu_items'] = $menuModel->findAll();
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
}