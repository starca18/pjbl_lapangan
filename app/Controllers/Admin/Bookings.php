<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BookingModel;
use App\Models\BookingSlotModel;
use App\Models\CourtModel;

class Bookings extends BaseController
{
    public function index()
    {
        $bookingModel = new BookingModel();

        $filters = [
            'date'           => $this->request->getGet('date'),
            'court_id'       => $this->request->getGet('court_id'),
            'status'         => $this->request->getGet('status'),
            'payment_status' => $this->request->getGet('payment_status'),
            'search'         => $this->request->getGet('q'),
        ];

        $bookings = $bookingModel->getBookingsWithCourt($filters);

        $courtModel = new CourtModel();
        $courts = $courtModel->findAll();

        return view('admin/bookings/index', [
            'title'    => 'Kelola Reservasi - Admin',
            'bookings' => $bookings,
            'courts'   => $courts,
            'filters'  => $filters,
        ]);
    }

    public function create()
    {
        $courtModel = new CourtModel();
        $courts = $courtModel->getCourtsWithCategory();

        $preSelectedCourt = $this->request->getGet('court_id');
        $preSelectedDate  = $this->request->getGet('date') ?: date('Y-m-d');
        $preSelectedSlot  = $this->request->getGet('slot');

        return view('admin/bookings/create', [
            'title'             => 'Tambah Reservasi Manual (Walk-in) - Admin',
            'courts'            => $courts,
            'preSelectedCourt'  => $preSelectedCourt,
            'preSelectedDate'   => $preSelectedDate,
            'preSelectedSlot'   => $preSelectedSlot,
            'timeSlots'         => time_slots(),
        ]);
    }

    public function store()
    {
        $courtId       = (int) $this->request->getPost('court_id');
        $bookingDate   = $this->request->getPost('booking_date');
        $slots         = $this->request->getPost('slots');
        $customerName  = trim($this->request->getPost('customer_name') ?? '');
        $customerPhone = trim($this->request->getPost('customer_phone') ?? '');
        $customerEmail = trim($this->request->getPost('customer_email') ?? '');
        $paymentMethod = $this->request->getPost('payment_method') ?: 'Tunai / Kasir';
        $paymentStatus = $this->request->getPost('payment_status') ?: 'paid';
        $bookingStatus = $this->request->getPost('status') ?: 'confirmed';
        $notes         = trim($this->request->getPost('notes') ?? '');

        if (!$courtId || !$bookingDate || empty($slots) || !is_array($slots) || empty($customerName) || empty($customerPhone)) {
            return redirect()->back()->withInput()->with('error', 'Harap isi semua kolom bertanda bintang dan pilih minimal 1 slot jam.');
        }

        $courtModel   = new CourtModel();
        $bookingModel = new BookingModel();
        $slotModel    = new BookingSlotModel();

        $court = $courtModel->find($courtId);
        if (!$court) {
            return redirect()->back()->with('error', 'Lapangan tidak valid.');
        }

        sort($slots);
        $totalHours = count($slots);
        $totalPrice = $totalHours * (float) $court['price_per_hour'];
        $startTime  = $slots[0];
        $lastSlot   = end($slots);
        $endTime    = date('H:i:s', strtotime($lastSlot . ' +1 hour'));

        $db = \Config\Database::connect();
        $db->transStart();

        if (! $slotModel->isAvailable($courtId, $bookingDate, $slots)) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Slot jam yang dipilih sudah dipesan sebelumnya.');
        }

        $bookingCode = $bookingModel->generateBookingCode();
        $bookingId = $bookingModel->insert([
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
            'payment_status' => $paymentStatus,
            'status'         => $bookingStatus,
            'notes'          => $notes,
        ]);

        $slotModel->reserveSlots($bookingId, $courtId, $bookingDate, $slots);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan reservasi.');
        }

        return redirect()->to(base_url('admin/bookings'))->with('success', 'Reservasi manual berhasil disimpan dengan kode: ' . $bookingCode);
    }

    public function detail($id)
    {
        $bookingModel = new BookingModel();
        $slotModel    = new BookingSlotModel();

        $booking = $bookingModel->select('bookings.*, courts.name as court_name, courts.code as court_code, courts.court_type, courts.floor_type, courts.price_per_hour, courts.image as court_image, categories.name as category_name')
                                ->join('courts', 'courts.id = bookings.court_id')
                                ->join('categories', 'categories.id = courts.category_id')
                                ->where('bookings.id', $id)
                                ->first();

        if (!$booking) {
            return redirect()->to(base_url('admin/bookings'))->with('error', 'Data reservasi tidak ditemukan.');
        }

        $slots = $slotModel->where('booking_id', $id)->findAll();

        return view('admin/bookings/detail', [
            'title'   => 'Detail Reservasi ' . $booking['booking_code'] . ' - Admin',
            'booking' => $booking,
            'slots'   => $slots,
        ]);
    }

    public function updateStatus($id)
    {
        $bookingModel = new BookingModel();
        $slotModel    = new BookingSlotModel();

        $booking = $bookingModel->find($id);
        if (!$booking) {
            return redirect()->to(base_url('admin/bookings'))->with('error', 'Reservasi tidak ditemukan.');
        }

        $newStatus        = $this->request->getPost('status');
        $newPaymentStatus = $this->request->getPost('payment_status');

        $data = [
            'status'         => $newStatus,
            'payment_status' => $newPaymentStatus,
        ];

        // Handle slot release on cancellation
        if ($newStatus === 'cancelled' && $booking['status'] !== 'cancelled') {
            $slotModel->releaseSlots($id);
        } elseif ($newStatus !== 'cancelled' && $booking['status'] === 'cancelled') {
            // Re-allocate slots if reviving from cancelled
            // Generate list of hourly slots from start_time to end_time
            $current = strtotime($booking['start_time']);
            $end     = strtotime($booking['end_time']);
            $slots   = [];
            while ($current < $end) {
                $slots[] = date('H:i:s', $current);
                $current = strtotime('+1 hour', $current);
            }

            if ($slotModel->isAvailable($booking['court_id'], $booking['booking_date'], $slots)) {
                $slotModel->reserveSlots($id, $booking['court_id'], $booking['booking_date'], $slots);
            } else {
                return redirect()->back()->with('error', 'Tidak dapat mengaktifkan kembali reservasi karena slot jam tersebut sudah diisi reservasi lain.');
            }
        }

        $bookingModel->update($id, $data);

        return redirect()->back()->with('success', 'Status reservasi berhasil diperbarui.');
    }

    public function printReceipt($id)
    {
        $bookingModel = new BookingModel();
        $booking = $bookingModel->select('bookings.*, courts.name as court_name, courts.code as court_code, courts.court_type, courts.floor_type, courts.price_per_hour, categories.name as category_name')
                                ->join('courts', 'courts.id = bookings.court_id')
                                ->join('categories', 'categories.id = courts.category_id')
                                ->where('bookings.id', $id)
                                ->first();

        if (!$booking) {
            return redirect()->to(base_url('admin/bookings'))->with('error', 'Data tidak ditemukan.');
        }

        return view('admin/bookings/print', [
            'title'   => 'Struk Reservasi ' . $booking['booking_code'],
            'booking' => $booking,
        ]);
    }
}
