<?php

namespace App\Models;

use CodeIgniter\Model;

class BookingSlotModel extends Model
{
    protected $table            = 'booking_slots';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'booking_id',
        'court_id',
        'booking_date',
        'slot_time',
        'created_at',
    ];

    public function getOccupiedSlots(int $courtId, string $date)
    {
        return $this->select('booking_slots.slot_time, bookings.id as booking_id, bookings.booking_code, bookings.customer_name, bookings.status as booking_status')
                    ->join('bookings', 'bookings.id = booking_slots.booking_id')
                    ->where('booking_slots.court_id', $courtId)
                    ->where('booking_slots.booking_date', $date)
                    ->whereIn('bookings.status', ['confirmed', 'pending', 'completed'])
                    ->findAll();
    }

    public function getAllOccupiedSlotsByDate(string $date)
    {
        return $this->select('booking_slots.court_id, booking_slots.slot_time, bookings.id as booking_id, bookings.booking_code, bookings.customer_name, bookings.status as booking_status')
                    ->join('bookings', 'bookings.id = booking_slots.booking_id')
                    ->where('booking_slots.booking_date', $date)
                    ->whereIn('bookings.status', ['confirmed', 'pending', 'completed'])
                    ->findAll();
    }

    public function isAvailable(int $courtId, string $date, array $slotTimes): bool
    {
        if (empty($slotTimes)) {
            return false;
        }

        $count = $this->join('bookings', 'bookings.id = booking_slots.booking_id')
                      ->where('booking_slots.court_id', $courtId)
                      ->where('booking_slots.booking_date', $date)
                      ->whereIn('booking_slots.slot_time', $slotTimes)
                      ->whereIn('bookings.status', ['confirmed', 'pending', 'completed'])
                      ->countAllResults();

        return $count === 0;
    }

    public function reserveSlots(int $bookingId, int $courtId, string $date, array $slotTimes): bool
    {
        $batch = [];
        $now = date('Y-m-d H:i:s');

        foreach ($slotTimes as $time) {
            $batch[] = [
                'booking_id'   => $bookingId,
                'court_id'     => $courtId,
                'booking_date' => $date,
                'slot_time'    => $time,
                'created_at'   => $now,
            ];
        }

        return (bool) $this->insertBatch($batch);
    }

    public function releaseSlots(int $bookingId)
    {
        return $this->where('booking_id', $bookingId)->delete();
    }
}
