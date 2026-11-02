<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\CourtModel;
use App\Models\BookingSlotModel;

class Home extends BaseController
{
    public function index()
    {
        $categoryModel = new CategoryModel();
        $courtModel    = new CourtModel();
        $slotModel     = new BookingSlotModel();

        $today = date('Y-m-d');
        $categories = $categoryModel->getWithCourtsCount();
        $courts     = $courtModel->getCourtsWithCategory();
        $occupiedSlots = $slotModel->getAllOccupiedSlotsByDate($today);

        // Group occupied slots by court_id
        $slotsByCourt = [];
        foreach ($occupiedSlots as $slot) {
            $slotsByCourt[$slot['court_id']][$slot['slot_time']] = $slot;
        }

        $allTimeSlots = time_slots();

        return view('frontend/home', [
            'title'        => 'ArenaSport - Reservasi Lapangan Olahraga Terlengkap',
            'categories'   => $categories,
            'courts'       => $courts,
            'today'        => $today,
            'timeSlots'    => $allTimeSlots,
            'slotsByCourt' => $slotsByCourt,
        ]);
    }
}
