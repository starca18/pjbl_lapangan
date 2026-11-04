<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BookingModel;
use App\Models\CourtModel;
use App\Models\BookingSlotModel;
use App\Models\CategoryModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $bookingModel  = new BookingModel();
        $courtModel    = new CourtModel();
        $slotModel     = new BookingSlotModel();
        $categoryModel = new CategoryModel();

        $today = date('Y-m-d');

        // Statistics
        $totalCourts = $courtModel->where('is_active', 1)->countAllResults();
        $todayBookings = $bookingModel->where('booking_date', $today)
                                      ->whereIn('status', ['confirmed', 'completed'])
                                      ->countAllResults();

        $pendingBookings = $bookingModel->where('status', 'pending')->countAllResults();

        // Total revenue
        $revenueRow = $bookingModel->selectSum('total_price')
                                   ->where('payment_status', 'paid')
                                   ->first();
        $totalRevenue = $revenueRow['total_price'] ?? 0;

        // Today's revenue
        $todayRevenueRow = $bookingModel->selectSum('total_price')
                                        ->where('booking_date', $today)
                                        ->where('payment_status', 'paid')
                                        ->first();
        $todayRevenue = $todayRevenueRow['total_price'] ?? 0;

        // Recent Bookings
        $recentBookings = $bookingModel->getBookingsWithCourt([]);
        $recentBookings = array_slice($recentBookings, 0, 8);

        // Today's slots summary & capacity
        $occupiedSlots = $slotModel->getAllOccupiedSlotsByDate($today);
        $allCourts     = $courtModel->getCourtsWithCategory();
        $categories    = $categoryModel->getWithCourtsCount();

        $occupiedCount = count($occupiedSlots);
        $totalCapacity = $totalCourts * 16; // 07:00 to 23:00 (16 slots/court)
        $occupancyRate = $totalCapacity > 0 ? min(100, round(($occupiedCount / $totalCapacity) * 100)) : 0;

        return view('admin/dashboard', [
            'title'           => 'Dashboard Admin - ArenaSport',
            'totalCourts'     => $totalCourts,
            'todayBookings'   => $todayBookings,
            'pendingBookings' => $pendingBookings,
            'totalRevenue'    => $totalRevenue,
            'todayRevenue'    => $todayRevenue,
            'recentBookings'  => $recentBookings,
            'today'           => $today,
            'courts'          => $allCourts,
            'categories'      => $categories,
            'occupiedCount'   => $occupiedCount,
            'totalCapacity'   => $totalCapacity,
            'occupancyRate'   => $occupancyRate,
        ]);
    }
}
