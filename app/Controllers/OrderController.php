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

        return view('orders/receipt', $data);
    }
    
    public function complete($id)
    {
        $orderModel = new OrderModel();
        $tableModel = new TableModel();

        // Find the order to get the table_id
        $order = $orderModel->find($id);
        if ($order) {
            // Update table status to Available
            $tableModel->update($order['table_id'], ['status' => 'Available']);
            // Update order status to Completed
            $orderModel->update($id, ['status' => 'Completed']);
        }
        
        return redirect()->to('/orders')->with('status', 'Order marked as completed and table is now available.');
    }
}