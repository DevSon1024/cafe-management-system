<?php namespace App\Controllers;

use App\Models\UserModel;
use App\Models\OrderModel;

class UserController extends BaseController
{
    public function login()
    {
        // If the user is already logged in, redirect them to their dashboard
        if (session()->get('isLoggedIn')) {
            return redirect()->to(session()->get('role') === 'admin' ? '/' : '/user/dashboard');
        }

        return view('auth/login');
    }

    // In app/Controllers/UserController.php
    public function authenticate()
    {
        $session = session();
        $model = new UserModel();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $user = $model->where('email', $email)->first();

        if (is_null($user)) {
            return redirect()->back()->withInput()->with('error', 'Invalid email or password.');
        }

        // UPDATED ROLE CHECK
        $allowed_roles = ['admin', 'chef', 'cashier'];
        if (!in_array($user['role'], $allowed_roles)) {
            return redirect()->back()->withInput()->with('error', 'Access denied.');
        }

        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Invalid email or password.');
        }

        $ses_data = [
            'user_id'    => $user['id'],
            'name'       => $user['name'],
            'email'      => $user['email'],
            'role'       => $user['role'],
            'isLoggedIn' => TRUE
        ];
        $session->set($ses_data);

        // CORRECTED REDIRECT LOGIC
        if ($user['role'] === 'admin') {
            return redirect()->to('/admin/dashboard');
        } elseif ($user['role'] === 'chef') {
            return redirect()->to('/chef/dashboard');
        } elseif ($user['role'] === 'cashier') {
            return redirect()->to('/cashier/dashboard');
        }

        return redirect()->to('/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}