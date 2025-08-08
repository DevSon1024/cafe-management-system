<?php namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Admin implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // If user is not an admin, redirect them to their dashboard or login
        if (session()->get('role') !== 'admin') {
            // If they are logged in but not an admin, send to user dashboard
            if (session()->get('isLoggedIn')) {
                return redirect()->to('/user/dashboard');
            }
            // If not logged in at all, send to login
            return redirect()->to('/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}