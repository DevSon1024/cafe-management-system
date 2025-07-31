<?php namespace App\Models;

use CodeIgniter\Model;

class TableModel extends Model
{
    protected $table = 'tables';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'status'];
}