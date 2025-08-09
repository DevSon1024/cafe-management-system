<?php namespace App\Controllers;

use App\Models\UserModel;

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

        if ($user['role'] === 'admin') {
            return redirect()->to('/admin/dashboard'); // Corrected redirect
        }
        
        return redirect()->to('/user/dashboard');
    }
    public function register()
    {
        return view('auth/register');
    }

    public function store()
    {
        $model = new UserModel();

        $data = [
            'name'     => $this->request->getVar('name'),
            'email'    => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'role'     => 'user' // Default role for new registrations
        ];

        // Basic validation
        if (empty($data['name']) || empty($data['email']) || empty($this->request->getVar('password'))) {
            return redirect()->back()->withInput()->with('error', 'All fields are required.');
        }

        if ($model->save($data)) {
            return redirect()->to('/login')->with('success', 'Registration successful. Please login.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Registration failed.');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    // Example of a user-specific dashboard
    public function dashboard()
    {
        // This is a protected area for logged-in users
        // You would load user-specific data here
        return view('user/dashboard');
    }
}