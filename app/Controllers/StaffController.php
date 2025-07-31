<?php namespace App\Controllers;

use App\Models\StaffModel;

class StaffController extends BaseController
{
    public function index()
    {
        $model = new StaffModel();
        $data['staff'] = $model->findAll();
        return view('staff/index', $data);
    }

    public function new()
    {
        return view('staff/create');
    }

    public function create()
    {
        $model = new StaffModel();
        $data = [
            'name' => $this->request->getPost('name'),
            'role' => $this->request->getPost('role'),
            'shift' => $this->request->getPost('shift'),
        ];
        $model->save($data);
        return redirect()->to('/staff')->with('status', 'Staff Member Added Successfully');
    }

    public function edit($id = null)
    {
        $model = new StaffModel();
        $data['staff_member'] = $model->find($id);
        return view('staff/edit', $data);
    }

    public function update($id = null)
    {
        $model = new StaffModel();
        $data = [
            'name' => $this->request->getPost('name'),
            'role' => $this->request->getPost('role'),
            'shift' => $this->request->getPost('shift'),
        ];
        $model->update($id, $data);
        return redirect()->to('/staff')->with('status', 'Staff Member Updated Successfully');
    }

    public function delete($id = null)
    {
        $model = new StaffModel();
        $model->delete($id);
        return redirect()->to('/staff')->with('status', 'Staff Member Deleted Successfully');
    }
}