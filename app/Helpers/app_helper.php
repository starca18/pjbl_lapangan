<?php

if (! function_exists('time_slots')) {
    function time_slots(): array
    {
        return [
            '07:00:00' => '07:00 - 08:00',
            '08:00:00' => '08:00 - 09:00',
            '09:00:00' => '09:00 - 10:00',
            '10:00:00' => '10:00 - 11:00',
            '11:00:00' => '11:00 - 12:00',
            '12:00:00' => '12:00 - 13:00',
            '13:00:00' => '13:00 - 14:00',
            '14:00:00' => '14:00 - 15:00',
            '15:00:00' => '15:00 - 16:00',
            '16:00:00' => '16:00 - 17:00',
            '17:00:00' => '17:00 - 18:00',
            '18:00:00' => '18:00 - 19:00',
            '19:00:00' => '19:00 - 20:00',
            '20:00:00' => '20:00 - 21:00',
            '21:00:00' => '21:00 - 22:00',
            '22:00:00' => '22:00 - 23:00',
        ];
    }
}

if (! function_exists('rupiah')) {
    function rupiah($number): string
    {
        return 'Rp ' . number_format((float) $number, 0, ',', '.');
    }
}

if (! function_exists('tanggal_indonesia')) {
    function tanggal_indonesia($dateString): string
    {
        if (empty($dateString)) {
            return '-';
        }

        $timestamp = strtotime($dateString);
        $days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $months = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        $dayName = $days[date('w', $timestamp)];
        $day = date('j', $timestamp);
        $month = $months[(int) date('n', $timestamp)];
        $year = date('Y', $timestamp);

        return "{$dayName}, {$day} {$month} {$year}";
    }
}

if (! function_exists('badge_status')) {
    function badge_status(string $status): string
    {
        switch ($status) {
            case 'confirmed':
                return '<span class="badge bg-success text-white px-2.5 py-1.5"><i class="bi bi-check-circle me-1"></i>Terkonfirmasi</span>';
            case 'pending':
                return '<span class="badge bg-warning text-dark px-2.5 py-1.5"><i class="bi bi-hourglass-split me-1"></i>Menunggu</span>';
            case 'completed':
                return '<span class="badge bg-primary text-white px-2.5 py-1.5"><i class="bi bi-flag me-1"></i>Selesai</span>';
            case 'cancelled':
                return '<span class="badge bg-danger text-white px-2.5 py-1.5"><i class="bi bi-x-circle me-1"></i>Dibatalkan</span>';
            default:
                return '<span class="badge bg-secondary">' . esc(ucfirst($status)) . '</span>';
        }
    }
}

if (! function_exists('badge_payment')) {
    function badge_payment(string $status): string
    {
        switch ($status) {
            case 'paid':
                return '<span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1"><i class="bi bi-cash-stack me-1"></i>Lunas</span>';
            case 'dp':
                return '<span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1"><i class="bi bi-pie-chart me-1"></i>DP (Uang Muka)</span>';
            case 'unpaid':
            default:
                return '<span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1"><i class="bi bi-clock me-1"></i>Belum Lunas</span>';
        }
    }
}
