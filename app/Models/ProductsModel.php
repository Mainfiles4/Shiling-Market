<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductsModel extends Model
{
    protected $table      = 'products';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $allowedFields = ['user_id', 'name', 'description', 'price', 'quantity', 'category', 'image', 'created_at'];

    // You can define validation rules, callbacks, etc., as needed
}
