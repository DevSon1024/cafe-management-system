<?php namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $allowedFields = ['table_id', 'user_id', 'total_amount', 'status'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

    public function getOrdersWithDetails()
    {
        return $this->select('orders.*, tables.name as table_name')
                    ->join('tables', 'tables.id = orders.table_id')
                    ->orderBy('orders.created_at', 'DESC')
                    ->findAll();
    }

    public function getOrderDetails($id)
    {
        return $this->select('orders.*, tables.name as table_name')
                    ->join('tables', 'tables.id = orders.table_id')
                    ->where('orders.id', $id)
                    ->first();
    }
    
    public function getOrdersByUserId($userId)
    {
        return $this->select('orders.*, tables.name as table_name')
                    ->join('tables', 'tables.id = orders.table_id')
                    ->where('orders.user_id', $userId)
                    ->orderBy('orders.created_at', 'DESC')
                    ->findAll();
    }
}