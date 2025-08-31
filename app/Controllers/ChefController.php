<?php namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\TableModel; // Import TableModel

class ChefController extends BaseController
{
    public function index()
    {
        $orderModel = new OrderModel();
        $data['orders'] = $orderModel
            ->whereIn('orders.status', ['Pending', 'In Making'])
            ->getOrdersWithDetails();
        return view('chef/dashboard', $data);
    }

    public function update_status($id)
    {
        $orderModel = new OrderModel();
        $tableModel = new TableModel();
        $status = $this->request->getPost('status');
        
        $orderModel->update($id, ['status' => $status]);

        // If order is completed, make the table available
        if ($status === 'Completed') {
            $order = $orderModel->find($id);
            if ($order && !empty($order['table_id'])) {
                $tableModel->update($order['table_id'], ['status' => 'Available']);
            }
        }

        return redirect()->to('/chef/dashboard')->with('status', 'Order status updated successfully.');
    }

    public function order_history()
    {
        $orderModel = new OrderModel();
        $data['orders'] = $orderModel
            ->where('orders.status', 'Completed')
            ->getOrdersWithDetails();
        return view('chef/order_history', $data);
    }
}
