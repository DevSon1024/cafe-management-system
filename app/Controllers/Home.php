<?php namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\MenuModel;
use App\Models\TableModel;

class Home extends BaseController
{
    public function index()
    {
        $orderModel = new OrderModel();
        $menuModel = new MenuModel();
        $tableModel = new TableModel();

        $dailySales = $orderModel->select('DATE(created_at) as sale_date, SUM(total_amount) as total_sales')
                                 ->where('status', 'Completed')
                                 ->groupBy('DATE(created_at)')
                                 ->orderBy('sale_date', 'DESC')
                                 ->findAll(7); // Get the last 7 days of sales

         $data = [
            'pending_orders'   => $orderModel->where('status', 'Pending')->countAllResults(),
            'total_menu_items' => $menuModel->countAllResults(),
            'available_tables' => $tableModel->where('status', 'Available')->countAllResults(),
            'todays_sales'     => $orderModel->selectSum('total_amount')
                                              ->where('status', 'Completed')
                                              ->where('DATE(created_at)', date('Y-m-d'))
                                              ->first()['total_amount'] ?? 0,
            'daily_sales'      => $dailySales
        ];

        return view('dashboard', $data);
    }
}