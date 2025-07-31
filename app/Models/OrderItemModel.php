<?php namespace App\Models;

use CodeIgniter\Model;

class OrderItemModel extends Model
{
    protected $table = 'order_items';
    protected $primaryKey = 'id';
    protected $allowedFields = ['order_id', 'item_id', 'quantity', 'subtotal'];

    public function getItemsByOrderId($order_id)
    {
        return $this->select('order_items.*, menu_items.name as item_name, menu_items.price as item_price')
                    ->join('menu_items', 'menu_items.id = order_items.item_id')
                    ->where('order_id', $order_id)
                    ->findAll();
    }
}