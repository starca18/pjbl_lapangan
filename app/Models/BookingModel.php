<?php

namespace App\Models;

use CodeIgniter\Model;

class BookingModel extends Model
{
    protected $table            = 'bookings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'booking_code',
        'court_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'booking_date',
        'start_time',
        'end_time',
        'total_hours',
        'total_price',
        'payment_method',
        'payment_status',
        'status',
        'notes',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getBookingsWithCourt($filters = [])
    {
        $builder = $this->select('bookings.*, courts.name as court_name, courts.code as court_code, categories.name as category_name, categories.icon as category_icon')
                        ->join('courts', 'courts.id = bookings.court_id')
                        ->join('categories', 'categories.id = courts.category_id');

        if (!empty($filters['date'])) {
            $builder->where('bookings.booking_date', $filters['date']);
        }

        if (!empty($filters['court_id'])) {
            $builder->where('bookings.court_id', $filters['court_id']);
        }

        if (!empty($filters['status'])) {
            $builder->where('bookings.status', $filters['status']);
        }

        if (!empty($filters['payment_status'])) {
            $builder->where('bookings.payment_status', $filters['payment_status']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $builder->groupStart()
                    ->like('bookings.booking_code', $search)
                    ->orLike('bookings.customer_name', $search)
                    ->orLike('bookings.customer_phone', $search)
                    ->groupEnd();
        }

        return $builder->orderBy('bookings.booking_date', 'DESC')
                       ->orderBy('bookings.start_time', 'ASC')
                       ->findAll();
    }

    public function getByBookingCode(string $code)
    {
        return $this->select('bookings.*, courts.name as court_name, courts.code as court_code, courts.court_type, courts.floor_type, courts.price_per_hour, courts.image as court_image, categories.name as category_name')
                    ->join('courts', 'courts.id = bookings.court_id')
                    ->join('categories', 'categories.id = courts.category_id')
                    ->where('bookings.booking_code', $code)
                    ->first();
    }

    public function generateBookingCode(): string
    {
        $prefix = 'BK-' . date('Ymd') . '-';
        $last = $this->like('booking_code', $prefix, 'after')
                     ->orderBy('id', 'DESC')
                     ->first();

        if ($last) {
            $lastNumber = (int) substr($last['booking_code'], -3);
            $nextNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '001';
        }

        return $prefix . $nextNumber;
    }
}
