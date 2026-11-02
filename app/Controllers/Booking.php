<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\CourtModel;
use App\Models\BookingModel;
use App\Models\BookingSlotModel;

class Booking extends BaseController
{
    public function index()
    {
        $categoryModel = new CategoryModel();
        $courtModel    = new CourtModel();

        $selectedCategory = $this->request->getGet('category');
        $courtType        = $this->request->getGet('type');

        $categories = $categoryModel->getWithCourtsCount();
        $builder    = $courtModel->select('courts.*, categories.name as category_name, categories.slug as category_slug, categories.icon as category_icon')
                                 ->join('categories', 'categories.id = courts.category_id')
                                 ->where('courts.is_active', 1);

        if (!empty($selectedCategory)) {
            $builder->where('categories.slug', $selectedCategory);
        }

        if (!empty($courtType)) {
            $builder->where('courts.court_type', $courtType);
        }

        $courts = $builder->orderBy('courts.category_id', 'ASC')
                          ->orderBy('courts.name', 'ASC')
                          ->findAll();

        return view('frontend/booking_list', [
            'title'            => 'Pilih Lapangan Olahraga - ArenaSport',
            'categories'       => $categories,
            'courts'           => $courts,
            'selectedCategory' => $selectedCategory,
            'selectedType'     => $courtType,
        ]);
    }

    public function detail($courtId)
    {
        $courtModel    = new CourtModel();
        $slotModel     = new BookingSlotModel();

        $court = $courtModel->getCourtDetail($courtId);
        if (!$court) {
            return redirect()->to(base_url('booking'))->with('error', 'Lapangan tidak ditemukan.');
        }

        $selectedDate = $this->request->getGet('date') ?: date('Y-m-d');
        $occupied = $slotModel->getOccupiedSlots((int) $courtId, $selectedDate);

        $occupiedMap = [];
        foreach ($occupied as $row) {
            $occupiedMap[$row['slot_time']] = $row['booking_status'];
        }

        $allTimeSlots = time_slots();

        return view('frontend/booking_detail', [
            'title'        => 'Reservasi ' . $court['name'] . ' - ArenaSport',
            'court'        => $court,
            'selectedDate' => $selectedDate,
            'timeSlots'    => $allTimeSlots,
            'occupiedMap'  => $occupiedMap,
            'preselected'      => $this->request->getGet('slot') ?: '',
            'preselectedSlots' => !empty($this->request->getGet('slots')) ? array_filter(array_map('trim', explode(',', $this->request->getGet('slots')))) : (!empty($this->request->getGet('slot')) ? [$this->request->getGet('slot')] : []),
        ]);
    }

    public function process()
    {
        $courtId       = (int) $this->request->getPost('court_id');
        $bookingDate   = $this->request->getPost('booking_date');
        $slots         = $this->request->getPost('slots');
        $customerName  = trim($this->request->getPost('customer_name') ?? '');
        $customerPhone = trim($this->request->getPost('customer_phone') ?? '');
        $customerEmail = trim($this->request->getPost('customer_email') ?? '');
        $paymentMethod = $this->request->getPost('payment_method') ?: 'Transfer Bank';
        $notes         = trim($this->request->getPost('notes') ?? '');

        // Basic Validation
        if (!$courtId || !$bookingDate || empty($slots) || !is_array($slots) || empty($customerName) || empty($customerPhone)) {
            return redirect()->back()->withInput()->with('error', 'Harap lengkapi semua kolom wajib dan pilih minimal 1 slot jam.');
        }

        if (strtotime($bookingDate) < strtotime(date('Y-m-d'))) {
            return redirect()->back()->withInput()->with('error', 'Tanggal reservasi tidak boleh sebelum hari ini.');
        }

        $courtModel    = new CourtModel();
        $bookingModel  = new BookingModel();
        $slotModel     = new BookingSlotModel();

        $court = $courtModel->find($courtId);
        if (!$court || !$court['is_active']) {
            return redirect()->back()->with('error', 'Lapangan tidak valid atau sedang tidak aktif.');
        }

        // Sort slots chronologically
        sort($slots);
        $totalHours = count($slots);
        $totalPrice = $totalHours * (float) $court['price_per_hour'];

        $startTime = $slots[0];
        $lastSlot = end($slots);
        // End time is 1 hour after the last slot start
        $endTime = date('H:i:s', strtotime($lastSlot . ' +1 hour'));

        $db = \Config\Database::connect();
        $db->transStart();

        // 1. Check slot conflict inside transaction
        if (! $slotModel->isAvailable($courtId, $bookingDate, $slots)) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Maaf, salah satu jam yang Anda pilih sudah terisi / dibooking oleh pelanggan lain. Silakan periksa kembali ketersediaan jadwal.');
        }

        // 2. Insert booking
        $bookingCode = $bookingModel->generateBookingCode();
        $bookingData = [
            'booking_code'   => $bookingCode,
            'court_id'       => $courtId,
            'customer_name'  => $customerName,
            'customer_phone' => $customerPhone,
            'customer_email' => $customerEmail,
            'booking_date'   => $bookingDate,
            'start_time'     => $startTime,
            'end_time'       => $endTime,
            'total_hours'    => $totalHours,
            'total_price'    => $totalPrice,
            'payment_method' => $paymentMethod,
            'payment_status' => 'unpaid',
            'status'         => 'pending',
            'notes'          => $notes,
        ];

        $bookingId = $bookingModel->insert($bookingData);

        // 3. Insert slots
        $slotModel->reserveSlots($bookingId, $courtId, $bookingDate, $slots);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem saat memproses reservasi. Silakan coba kembali.');
        }

        return redirect()->to(base_url('booking/success/' . $bookingCode))->with('success', 'Reservasi berhasil dibuat! Silakan simpan kode booking Anda dan selesaikan konfirmasi pembayaran.');
    }

    public function success($bookingCode)
    {
        $bookingModel = new BookingModel();
        $booking = $bookingModel->getByBookingCode($bookingCode);

        if (!$booking) {
            return redirect()->to(base_url())->with('error', 'Data reservasi tidak ditemukan.');
        }

        return view('frontend/booking_success', [
            'title'   => 'Bukti Reservasi ' . $booking['booking_code'] . ' - ArenaSport',
            'booking' => $booking,
        ]);
    }

    public function lacak()
    {
        $bookingModel = new BookingModel();
        $keyword = strtoupper(trim($this->request->getGet('q') ?? ''));
        $results = [];

        if (!empty($keyword)) {
            // Wajib kode booking spesifik (minimal 8 karakter) untuk melindungi privasi data
            if (strlen($keyword) >= 8 && preg_match('/^[A-Z0-9\-]+$/', $keyword)) {
                $results = $bookingModel->getBookingsWithCourt(['booking_code' => $keyword]);
            } else {
                session()->setFlashdata('error', 'Format kode booking tidak sesuai. Harap masukkan kode booking lengkap (contoh: BK-' . date('Ymd') . '-XXXX).');
            }
        }

        return view('frontend/lacak', [
            'title'   => 'Lacak Status Reservasi - ArenaSport',
            'keyword' => $keyword,
            'results' => $results,
        ]);
    }
}
