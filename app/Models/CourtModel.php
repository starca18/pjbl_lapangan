<?php

namespace App\Models;

use CodeIgniter\Model;

class CourtModel extends Model
{
    protected $table            = 'courts';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'category_id',
        'code',
        'name',
        'court_type',
        'floor_type',
        'price_per_hour',
        'image',
        'description',
        'is_active',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getCourtsWithCategory($categoryId = null, $onlyActive = true)
    {
        $builder = $this->select('courts.*, categories.name as category_name, categories.slug as category_slug, categories.icon as category_icon')
                        ->join('categories', 'categories.id = courts.category_id');

        if ($onlyActive) {
            $builder->where('courts.is_active', 1);
        }

        if (!empty($categoryId)) {
            $builder->where('courts.category_id', $categoryId);
        }

        return $builder->orderBy('courts.id', 'ASC')->findAll();
    }

    public function getCourtDetail($courtId)
    {
        return $this->select('courts.*, categories.name as category_name, categories.slug as category_slug, categories.icon as category_icon')
                    ->join('categories', 'categories.id = courts.category_id')
                    ->where('courts.id', $courtId)
                    ->first();
    }
}
