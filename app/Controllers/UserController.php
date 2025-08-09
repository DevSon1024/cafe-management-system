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

    public function orders()
    {
        $orderModel = new OrderModel();
        $userId = session()->get('user_id');

        $data['orders'] = $orderModel->getOrdersByUserId($userId);

        // Logic for the time-sensitive message
        $hour = date('H');
        if ($hour < 12) {
            $data['greeting_message'] = "Start your tasty day with our delicious breakfast!";
        } elseif ($hour < 17) {
            $data['greeting_message'] = "Feeling hungry? Our lunch menu has just what you need!";
        } else {
            $data['greeting_message'] = "End your day on a high note with a wonderful dinner.";
        }

        return view('user/orders', $data);
    }

    public function store()
    {
        $model = new UserModel();

        // Validation Rules
        $rules = [
            'name'             => 'required|min_length[3]|max_length[255]',
            'email'            => 'required|valid_email|is_unique[users.email]',
            'password'         => 'required|min_length[8]',
            'password_confirm' => 'matches[password]',
        ];

        if (! $this->validate($rules)) {
            // Pass validation errors to the view
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // If validation passes, save the user
        $data = [
            'name'     => $this->request->getVar('name'),
            'email'    => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'role'     => 'user'
        ];

        if ($model->save($data)) {
            return redirect()->to('/login')->with('success', 'Registration successful. Please login.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Registration failed. Please try again.');
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