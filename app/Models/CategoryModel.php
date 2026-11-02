<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table            = 'categories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'slug',
        'name',
        'icon',
        'description',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getWithCourtsCount()
    {
        return $this->select('categories.*, COUNT(courts.id) as courts_count, MIN(courts.price_per_hour) as min_price')
                    ->join('courts', 'courts.category_id = categories.id AND courts.is_active = 1', 'left')
                    ->groupBy('categories.id')
                    ->orderBy('categories.id', 'ASC')
                    ->findAll();
    }
}
