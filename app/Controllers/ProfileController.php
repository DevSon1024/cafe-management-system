<?php namespace App\Controllers;

use App\Models\UserModel;
use App\Models\OrderModel;

class ProfileController extends BaseController
{
    /**
     * Displays the profile view page for the logged-in user or admin.
     */
    public function index()
    {
        $userModel = new UserModel();
        $userId = session()->get('user_id');
        $data['user'] = $userModel->find($userId);

        if (session()->get('role') === 'admin') {
            // For admins, fetch all users for the management table
            $data['all_users'] = $userModel->findAll();
            return view('admin/profile', $data);
        }

        // For regular users, fetch their order history
        $orderModel = new OrderModel();
        $data['orders'] = $orderModel->getOrdersByUserId($userId);
        return view('user/profile', $data);
    }

    /**
     * Shows the form for editing a profile.
     */
    public function edit()
    {
        $userModel = new UserModel();
        $userId = session()->get('user_id');
        $data['user'] = $userModel->find($userId);

        if (session()->get('role') === 'admin') {
            return view('admin/edit_profile', $data);
        }

        return view('user/edit_profile', $data);
    }

    /**
     * Processes the profile update form submission.
     */
    public function update()
    {
        $userModel = new UserModel();
        $userId = session()->get('user_id');

        // Validation rules
        $rules = [
            'name'  => 'required|min_length[3]|max_length[255]',
            'email' => "required|valid_email|is_unique[users.email,id,{$userId}]",
        ];

        // If a password is provided, add it to the validation rules
        if ($this->request->getPost('password')) {
            $rules['password'] = 'required|min_length[8]';
            $rules['password_confirm'] = 'matches[password]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name'  => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        if ($userModel->update($userId, $data)) {
            // Update session data
            session()->set('name', $data['name']);
            session()->set('email', $data['email']);
            return redirect()->to(session()->get('role') === 'admin' ? '/admin/profile' : '/user/profile')->with('success', 'Profile updated successfully.');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to update profile.');
    }
}