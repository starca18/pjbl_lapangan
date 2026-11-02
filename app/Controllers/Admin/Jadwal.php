<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\CourtModel;
use App\Models\BookingSlotModel;

class Jadwal extends BaseController
{
    public function index()
    {
        $categoryModel = new CategoryModel();
        $courtModel    = new CourtModel();
        $slotModel     = new BookingSlotModel();

        $selectedDate = $this->request->getGet('date') ?: date('Y-m-d');
        $selectedCategory = $this->request->getGet('category') ?: '';

        $categories = $categoryModel->findAll();
        $courts     = $courtModel->getCourtsWithCategory(
            $selectedCategory ? (int) $selectedCategory : null
        );

        $allTimeSlots = time_slots();
        $occupiedSlots = $slotModel->getAllOccupiedSlotsByDate($selectedDate);

        $slotsByCourt = [];
        foreach ($occupiedSlots as $slot) {
            $slotsByCourt[$slot['court_id']][$slot['slot_time']] = $slot;
        }

        return view('admin/jadwal/index', [
            'title'            => 'Master Jadwal Lapangan - Admin',
            'categories'       => $categories,
            'courts'           => $courts,
            'selectedDate'     => $selectedDate,
            'selectedCategory' => $selectedCategory,
            'timeSlots'        => $allTimeSlots,
            'slotsByCourt'     => $slotsByCourt,
        ]);
    }
}
