<?php namespace App\Controllers;

use App\Models\StaffModel;
use App\Models\UserModel;

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
        $staffModel = new StaffModel();
        $userModel = new UserModel();

        $staffData = [
            'name' => $this->request->getPost('name'),
            'role' => $this->request->getPost('role'),
            'shift' => $this->request->getPost('shift'),
        ];

        if ($staffData['role'] !== 'Waiter') {
            $userData = [
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'role' => strtolower($staffData['role']),
            ];
            $userModel->save($userData);
            $staffData['user_id'] = $userModel->getInsertID();
        }

        $staffModel->save($staffData);
        return redirect()->to('/admin/staff')->with('status', 'Staff Member Added Successfully');
    }

    public function edit($id = null)
    {
        $model = new StaffModel();
        $userModel = new UserModel();
        $data['staff_member'] = $model->find($id);

        if ($data['staff_member']['user_id']) {
            $data['user'] = $userModel->find($data['staff_member']['user_id']);
        } else {
            $data['user'] = null;
        }

        return view('staff/edit', $data);
    }

    public function update($id = null)
    {
        $staffModel = new StaffModel();
        $userModel = new UserModel();

        $staffData = [
            'name' => $this->request->getPost('name'),
            'role' => $this->request->getPost('role'),
            'shift' => $this->request->getPost('shift'),
        ];
        $staffModel->update($id, $staffData);

        $staffMember = $staffModel->find($id);
        if ($staffMember['user_id']) {
            $userData = [
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'role' => strtolower($this->request->getPost('role')),
            ];

            if ($this->request->getPost('password')) {
                $userData['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
            }
            $userModel->update($staffMember['user_id'], $userData);
        }

        return redirect()->to('/admin/staff')->with('status', 'Staff Member Updated Successfully');
    }

    public function delete($id = null)
    {
        $model = new StaffModel();
        $model->delete($id);
        return redirect()->to('/admin/staff')->with('status', 'Staff Member Deleted Successfully');
    }
}