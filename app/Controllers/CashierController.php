<?php namespace App\Controllers;

class CashierController extends BaseController
{
    public function index()
    {
        return view('cashier/dashboard');
    }
}