<?php namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table = 'menu_items';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'category_id', 'price', 'image'];
    
    public function getMenuItemsWithCategories()
    {
        return $this->select('menu_items.*, categories.name as category_name')
                    ->join('categories', 'categories.id = menu_items.category_id', 'left')
                    ->findAll();
    }
}