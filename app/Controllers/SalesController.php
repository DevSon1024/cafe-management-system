<?php namespace App\Controllers;

use App\Models\OrderModel;

class SalesController extends BaseController
{
    public function index()
    {
        $orderModel = new OrderModel();
        
        // Get filter dates from the request, with defaults
        $startDate = $this->request->getGet('start_date') ?? date('Y-m-d', strtotime('-7 days'));
        $endDate = $this->request->getGet('end_date') ?? date('Y-m-d');

        // Fetch sales data within the date range
        $salesData = $orderModel->select('DATE(created_at) as sale_date, SUM(total_amount) as total_sales')
                                ->where('status', 'Completed')
                                ->where('DATE(created_at) >=', $startDate)
                                ->where('DATE(created_at) <=', $endDate)
                                ->groupBy('DATE(created_at)')
                                ->orderBy('sale_date', 'DESC')
                                ->findAll();

        $data = [
            'sales_data' => $salesData,
            'start_date' => $startDate,
            'end_date'   => $endDate
        ];

        return view('sales/index', $data);
    }
}