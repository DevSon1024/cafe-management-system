<?php namespace App\Controllers;

use App\Models\OrderModel;

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
        $status = $this->request->getPost('status');
        $orderModel->update($id, ['status' => $status]);
        return redirect()->to('/chef/dashboard')->with('status', 'Order status updated successfully.');
    }
}