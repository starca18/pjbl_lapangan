<?php

namespace App\Controllers;

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
        $selectedCourt = $this->request->getGet('court') ?: '';

        $categories = $categoryModel->getWithCourtsCount();
        $courts     = $courtModel->getCourtsWithCategory(
            $selectedCategory ? (int) $selectedCategory : null
        );

        if (!empty($selectedCourt)) {
            $courts = array_filter($courts, function ($c) use ($selectedCourt) {
                return (int) $c['id'] === (int) $selectedCourt;
            });
        }

        $allTimeSlots = time_slots();
        $occupiedSlots = $slotModel->getAllOccupiedSlotsByDate($selectedDate);

        $slotsByCourt = [];
        $totalBookedCount = 0;
        $totalPendingCount = 0;

        foreach ($occupiedSlots as $slot) {
            $slotsByCourt[$slot['court_id']][$slot['slot_time']] = $slot;
            if ($slot['booking_status'] === 'confirmed' || $slot['booking_status'] === 'completed') {
                $totalBookedCount++;
            } elseif ($slot['booking_status'] === 'pending') {
                $totalPendingCount++;
            }
        }

        $totalCapacity = count($courts) * count($allTimeSlots);
        $totalAvailable = max(0, $totalCapacity - $totalBookedCount - $totalPendingCount);

        // Date ribbon for TIX ID layout (Next 14 days)
        $dateList = [];
        $todayTs = strtotime(date("Y-m-d"));
        $daysIndo = ["MIN", "SEN", "SEL", "RAB", "KAM", "JUM", "SAB"];
        $monthsIndo = [1 => "Jan", 2 => "Feb", 3 => "Mar", 4 => "Apr", 5 => "Mei", 6 => "Jun", 7 => "Jul", 8 => "Agu", 9 => "Sep", 10 => "Okt", 11 => "Nov", 12 => "Des"];
        for ($d = 0; $d < 14; $d++) {
            $ts = strtotime("+{$d} days", $todayTs);
            $ymd = date("Y-m-d", $ts);
            $dateList[] = [
                "date"        => $ymd,
                "day_num"     => date("d", $ts),
                "month"       => $monthsIndo[(int) date("n", $ts)],
                "day_name"    => $d === 0 ? "HARI INI" : ($d === 1 ? "BESOK" : $daysIndo[(int) date("w", $ts)]),
                "is_today"    => $d === 0,
                "is_selected" => $ymd === $selectedDate,
            ];
        }

        $currentTime = date("H:i:s");

        return view('frontend/jadwal', [
            'title'             => 'Papan Jadwal Ketersediaan Lapangan - ArenaSport',
            'categories'        => $categories,
            'courts'            => $courts,
            'selectedDate'      => $selectedDate,
            'selectedCategory'  => $selectedCategory,
            'selectedCourt'     => $selectedCourt,
            'timeSlots'         => $allTimeSlots,
            'slotsByCourt'      => $slotsByCourt,
            'totalBookedCount'  => $totalBookedCount,
            'totalPendingCount' => $totalPendingCount,
            'totalAvailable'    => $totalAvailable,
            'totalCapacity'     => $totalCapacity,
            'dateList'          => $dateList,
            'currentTime'       => $currentTime,
        ]);
    }

    public function slotsData()
    {
        $courtId = (int) $this->request->getGet('court_id');
        $date    = $this->request->getGet('date') ?: date('Y-m-d');

        if (!$courtId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Court ID required'
            ]);
        }

        $slotModel = new BookingSlotModel();
        $occupied = $slotModel->getOccupiedSlots($courtId, $date);

        $occupiedMap = [];
        foreach ($occupied as $row) {
            $occupiedMap[$row['slot_time']] = [
                'status'        => $row['booking_status'],
                'booking_code'  => $row['booking_code'],
                'customer_name' => $row['customer_name']
            ];
        }

        $allTimeSlots = time_slots();
        $results = [];

        foreach ($allTimeSlots as $time => $label) {
            $isOccupied = isset($occupiedMap[$time]);
            $results[] = [
                'time'      => $time,
                'label'     => $label,
                'available' => !$isOccupied,
                'status'    => $isOccupied ? $occupiedMap[$time]['status'] : 'available',
            ];
        }

        return $this->response->setJSON([
            'success' => true,
            'court_id' => $courtId,
            'date'     => $date,
            'slots'    => $results,
        ]);
    }
}
