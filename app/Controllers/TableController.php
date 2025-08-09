<?php namespace App\Controllers;

use App\Models\TableModel;
use App\Models\OrderModel;

class TableController extends BaseController
{
    public function index()
    {
        $model = new TableModel();
        $data['tables'] = $model->findAll();
        return view('tables/index', $data);
    }

    public function new()
    {
        return view('tables/create');
    }

    public function create()
    {
        $model = new TableModel();
        $data = [
            'name' => $this->request->getPost('name'),
            'status' => $this->request->getPost('status'),
        ];
        $model->save($data);
        return redirect()->to('/admin/tables')->with('status', 'Table Added Successfully');
    }

    public function edit($id = null)
    {
        $model = new TableModel();
        $data['table'] = $model->find($id);
        return view('tables/edit', $data);
    }

    public function update($id = null)
    {
        $model = new TableModel();
        $data = [
            'name' => $this->request->getPost('name'),
            'status' => $this->request->getPost('status'),
        ];
        $model->update($id, $data);
        return redirect()->to('/admin/tables')->with('status', 'Table Updated Successfully');
    }

    public function delete($id = null)
    {
        $tableModel = new TableModel();
        $orderModel = new OrderModel();

        // It's still wise to prevent deleting a table with PENDING orders.
        $pending_orders = $orderModel->where('table_id', $id)->where('status', 'Pending')->countAllResults();
        if ($pending_orders > 0) {
            return redirect()->to('/admin/tables')->with('error', 'Cannot delete this table because it has active, pending orders.');
        }

        // If no pending orders, delete the table.
        // Completed orders for this table will remain in the system for reporting.
        $tableModel->delete($id);
        return redirect()->to('/admin/tables')->with('status', 'Table Deleted Successfully');
    }
}