<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class ReservationSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        $today = date('Y-m-d');
        $tomorrow = date('Y-m-d', strtotime('+1 day'));

        // 1. Users
        $this->db->table('users')->insert([
            'username'   => 'admin',
            'password'   => password_hash('admin123', PASSWORD_BCRYPT),
            'full_name'  => 'Administrator Olahraga',
            'email'      => 'admin@arenasport.id',
            'phone'      => '081234567890',
            'role'       => 'admin',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 2. Categories
        $categories = [
            [
                'id'          => 1,
                'slug'        => 'futsal',
                'name'        => 'Futsal',
                'icon'        => 'bi-dribbble',
                'description' => 'Lapangan futsal standar kompetisi dengan pilihan lantai vinyl taraflex & rumput sintetis.',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 2,
                'slug'        => 'mini-soccer',
                'name'        => 'Mini Soccer',
                'icon'        => 'bi-shield-shaded',
                'description' => 'Lapangan mini soccer 7 vs 7 dengan rumput sintetis monofilament standar FIFA & lampu sorot LED.',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 3,
                'slug'        => 'badminton',
                'name'        => 'Badminton',
                'icon'        => 'bi-lightning-charge',
                'description' => 'Karpet vinyl matras standar BWF dengan sirkulasi udara sejuk dan pencahayaan anti-silau.',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 4,
                'slug'        => 'voli',
                'name'        => 'Bola Voli',
                'icon'        => 'bi-circle-half',
                'description' => 'Lapangan voli indoor dengan lantai parquet kayu interlock & jaring standar nasional PBVSI.',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 5,
                'slug'        => 'tenis',
                'name'        => 'Tenis Lapangan',
                'icon'        => 'bi-circle',
                'description' => 'Hard court acrylic standar ITF dengan peredaman pantulan bola optimal.',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 6,
                'slug'        => 'padel',
                'name'        => 'Padel',
                'icon'        => 'bi-grid-3x3',
                'description' => 'Lapangan padel terkini dengan dinding kaca tempered panoramic & rumput sintetis Mondo texturized.',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
        ];
        $this->db->table('categories')->insertBatch($categories);

        // 3. Courts
        $courts = [
            // Futsal
            [
                'id'             => 1,
                'category_id'    => 1,
                'code'           => 'FUT-01',
                'name'           => 'Futsal Vinyl Court A',
                'court_type'     => 'Indoor',
                'floor_type'     => 'Vinyl Taraflex 7mm',
                'price_per_hour' => 150000.00,
                'image'          => 'futsal_vinyl.jpg',
                'description'    => 'Lantai vinyl licin pas dan empuk, nyaman untuk lari cepat, aman bagi lutut.',
                'is_active'      => 1,
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            [
                'id'             => 2,
                'category_id'    => 1,
                'code'           => 'FUT-02',
                'name'           => 'Futsal Rumput Sintetis B',
                'court_type'     => 'Indoor',
                'floor_type'     => 'Rumput Sintetis Premium',
                'price_per_hour' => 135000.00,
                'image'          => 'futsal_rumput.jpg',
                'description'    => 'Rumput sintetis halus dengan butiran rubber infill berkualitas tinggi.',
                'is_active'      => 1,
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            // Mini Soccer
            [
                'id'             => 3,
                'category_id'    => 2,
                'code'           => 'MSC-01',
                'name'           => 'Mini Soccer Arena Stadium',
                'court_type'     => 'Outdoor',
                'floor_type'     => 'Rumput Monofilament 60mm',
                'price_per_hour' => 375000.00,
                'image'          => 'minisoccer.jpg',
                'description'    => 'Ukuran lapangan 7v7 (55m x 35m) lengkap dengan tribun penonton dan lampu sorot 800 Lux.',
                'is_active'      => 1,
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            // Badminton
            [
                'id'             => 4,
                'category_id'    => 3,
                'code'           => 'BDM-01',
                'name'           => 'Badminton Court 1 (Matras Hijau)',
                'court_type'     => 'Indoor',
                'floor_type'     => 'Matras Vinyl BWF Approved',
                'price_per_hour' => 65000.00,
                'image'          => 'badminton_1.jpg',
                'description'    => 'Matras profesional anti-slip dengan garis lapangan kontras presisi.',
                'is_active'      => 1,
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            [
                'id'             => 5,
                'category_id'    => 3,
                'code'           => 'BDM-02',
                'name'           => 'Badminton Court 2 (Matras Biru)',
                'court_type'     => 'Indoor',
                'floor_type'     => 'Matras Vinyl BWF Approved',
                'price_per_hour' => 65000.00,
                'image'          => 'badminton_2.jpg',
                'description'    => 'Lampu tidak silau dari atas bola, sirkulasi exhaust fan dingin.',
                'is_active'      => 1,
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            // Voli
            [
                'id'             => 6,
                'category_id'    => 4,
                'code'           => 'VOL-01',
                'name'           => 'Voli Indoor Hall',
                'court_type'     => 'Indoor',
                'floor_type'     => 'Interlocking Polypropylene Court',
                'price_per_hour' => 110000.00,
                'image'          => 'voli.jpg',
                'description'    => 'Langit-langit aula tinggi 10 meter, tiang dan net regulasi PBVSI.',
                'is_active'      => 1,
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            // Tenis
            [
                'id'             => 7,
                'category_id'    => 5,
                'code'           => 'TNS-01',
                'name'           => 'Tenis Center Court (Hard Court)',
                'court_type'     => 'Outdoor',
                'floor_type'     => 'Acrylic Plexipave Hard Court',
                'price_per_hour' => 125000.00,
                'image'          => 'tenis.jpg',
                'description'    => 'Pantulan bola medium-fast, garis rapi, tersedia bangku wasit dan canopy istirahat.',
                'is_active'      => 1,
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            // Padel
            [
                'id'             => 8,
                'category_id'    => 6,
                'code'           => 'PDL-01',
                'name'           => 'Padel Panoramic Court 1',
                'court_type'     => 'Indoor',
                'floor_type'     => 'Mondo Texturized Turf + Tempered Glass',
                'price_per_hour' => 220000.00,
                'image'          => 'padel_indoor.jpg',
                'description'    => 'Kaca panoramik tanpa pilar sudut pandang 360 derajat, rumput padel profesional.',
                'is_active'      => 1,
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            [
                'id'             => 9,
                'category_id'    => 6,
                'code'           => 'PDL-02',
                'name'           => 'Padel Sunset Outdoor Court 2',
                'court_type'     => 'Outdoor',
                'floor_type'     => 'Mondo Turf + Glass Enclosure',
                'price_per_hour' => 180000.00,
                'image'          => 'padel_outdoor.jpg',
                'description'    => 'Bermain padel di udara terbuka dengan pemandangan matahari sore dan pencahayaan malam.',
                'is_active'      => 1,
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
        ];
        $this->db->table('courts')->insertBatch($courts);

        // 4. Sample Bookings & Slots (So calendar schedule is vividly visible on first load!)
        $sampleBookings = [
            [
                'id'             => 1,
                'booking_code'   => 'BK-' . date('Ymd') . '-001',
                'court_id'       => 1, // Futsal Vinyl
                'customer_name'  => 'Rian Pratama (FC Galaxy)',
                'customer_phone' => '081298765432',
                'customer_email' => 'rian@example.com',
                'booking_date'   => $today,
                'start_time'     => '16:00:00',
                'end_time'       => '18:00:00',
                'total_hours'    => 2,
                'total_price'    => 300000.00,
                'payment_method' => 'Transfer BCA',
                'payment_status' => 'paid',
                'status'         => 'confirmed',
                'notes'          => 'Sparing tim futsal kantor',
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            [
                'id'             => 2,
                'booking_code'   => 'BK-' . date('Ymd') . '-002',
                'court_id'       => 3, // Mini Soccer
                'customer_name'  => 'Coach Dimas (Garuda Muda)',
                'customer_phone' => '085712349988',
                'customer_email' => 'dimas@example.com',
                'booking_date'   => $today,
                'start_time'     => '19:00:00',
                'end_time'       => '21:00:00',
                'total_hours'    => 2,
                'total_price'    => 750000.00,
                'payment_method' => 'QRIS',
                'payment_status' => 'paid',
                'status'         => 'confirmed',
                'notes'          => 'Latihan rutin komunitas mini soccer',
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            [
                'id'             => 3,
                'booking_code'   => 'BK-' . date('Ymd') . '-003',
                'court_id'       => 4, // Badminton 1
                'customer_name'  => 'Budi Santoso',
                'customer_phone' => '082133445566',
                'customer_email' => 'budi@example.com',
                'booking_date'   => $today,
                'start_time'     => '09:00:00',
                'end_time'       => '11:00:00',
                'total_hours'    => 2,
                'total_price'    => 130000.00,
                'payment_method' => 'Tunai / Kasir',
                'payment_status' => 'paid',
                'status'         => 'completed',
                'notes'          => 'Sewa raket 2 pcs',
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            [
                'id'             => 4,
                'booking_code'   => 'BK-' . date('Ymd') . '-004',
                'court_id'       => 8, // Padel Panoramic 1
                'customer_name'  => 'Kevin & Friends',
                'customer_phone' => '081377889900',
                'customer_email' => 'kevin@example.com',
                'booking_date'   => $today,
                'start_time'     => '19:00:00',
                'end_time'       => '21:00:00',
                'total_hours'    => 2,
                'total_price'    => 440000.00,
                'payment_method' => 'Transfer Mandiri',
                'payment_status' => 'paid',
                'status'         => 'confirmed',
                'notes'          => 'Game ganda padel',
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            [
                'id'             => 5,
                'booking_code'   => 'BK-' . date('Ymd') . '-005',
                'court_id'       => 7, // Tenis
                'customer_name'  => 'dr. Hendra Sp.A',
                'customer_phone' => '081822334455',
                'customer_email' => 'hendra@example.com',
                'booking_date'   => $today,
                'start_time'     => '07:00:00',
                'end_time'       => '09:00:00',
                'total_hours'    => 2,
                'total_price'    => 250000.00,
                'payment_method' => 'Transfer BCA',
                'payment_status' => 'paid',
                'status'         => 'completed',
                'notes'          => 'Pagi tenis rutin',
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            [
                'id'             => 6,
                'booking_code'   => 'BK-' . date('Ymd') . '-006',
                'court_id'       => 1, // Futsal Vinyl
                'customer_name'  => 'Aris Munandar',
                'customer_phone' => '087811223344',
                'customer_email' => 'aris@example.com',
                'booking_date'   => $today,
                'start_time'     => '20:00:00',
                'end_time'       => '22:00:00',
                'total_hours'    => 2,
                'total_price'    => 300000.00,
                'payment_method' => 'QRIS',
                'payment_status' => 'unpaid',
                'status'         => 'pending',
                'notes'          => 'Menunggu verifikasi pembayaran',
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            // Tomorrow sample
            [
                'id'             => 7,
                'booking_code'   => 'BK-' . date('Ymd', strtotime('+1 day')) . '-001',
                'court_id'       => 8, // Padel
                'customer_name'  => 'Sarah Wijaya',
                'customer_phone' => '081900112233',
                'customer_email' => 'sarah@example.com',
                'booking_date'   => $tomorrow,
                'start_time'     => '18:00:00',
                'end_time'       => '20:00:00',
                'total_hours'    => 2,
                'total_price'    => 440000.00,
                'payment_method' => 'QRIS',
                'payment_status' => 'paid',
                'status'         => 'confirmed',
                'notes'          => 'Padel evening match',
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
        ];
        $this->db->table('bookings')->insertBatch($sampleBookings);

        // Slots mapping for atomic schedule
        $slots = [
            // BK 1: Court 1, Today, 16:00 & 17:00
            ['booking_id' => 1, 'court_id' => 1, 'booking_date' => $today, 'slot_time' => '16:00:00', 'created_at' => $now],
            ['booking_id' => 1, 'court_id' => 1, 'booking_date' => $today, 'slot_time' => '17:00:00', 'created_at' => $now],

            // BK 2: Court 3, Today, 19:00 & 20:00
            ['booking_id' => 2, 'court_id' => 3, 'booking_date' => $today, 'slot_time' => '19:00:00', 'created_at' => $now],
            ['booking_id' => 2, 'court_id' => 3, 'booking_date' => $today, 'slot_time' => '20:00:00', 'created_at' => $now],

            // BK 3: Court 4, Today, 09:00 & 10:00
            ['booking_id' => 3, 'court_id' => 4, 'booking_date' => $today, 'slot_time' => '09:00:00', 'created_at' => $now],
            ['booking_id' => 3, 'court_id' => 4, 'booking_date' => $today, 'slot_time' => '10:00:00', 'created_at' => $now],

            // BK 4: Court 8, Today, 19:00 & 20:00
            ['booking_id' => 4, 'court_id' => 8, 'booking_date' => $today, 'slot_time' => '19:00:00', 'created_at' => $now],
            ['booking_id' => 4, 'court_id' => 8, 'booking_date' => $today, 'slot_time' => '20:00:00', 'created_at' => $now],

            // BK 5: Court 7, Today, 07:00 & 08:00
            ['booking_id' => 5, 'court_id' => 7, 'booking_date' => $today, 'slot_time' => '07:00:00', 'created_at' => $now],
            ['booking_id' => 5, 'court_id' => 7, 'booking_date' => $today, 'slot_time' => '08:00:00', 'created_at' => $now],

            // BK 6: Court 1, Today, 20:00 & 21:00 (Pending)
            ['booking_id' => 6, 'court_id' => 1, 'booking_date' => $today, 'slot_time' => '20:00:00', 'created_at' => $now],
            ['booking_id' => 6, 'court_id' => 1, 'booking_date' => $today, 'slot_time' => '21:00:00', 'created_at' => $now],

            // BK 7: Court 8, Tomorrow, 18:00 & 19:00
            ['booking_id' => 7, 'court_id' => 8, 'booking_date' => $tomorrow, 'slot_time' => '18:00:00', 'created_at' => $now],
            ['booking_id' => 7, 'court_id' => 8, 'booking_date' => $tomorrow, 'slot_time' => '19:00:00', 'created_at' => $now],
        ];
        $this->db->table('booking_slots')->insertBatch($slots);
    }
}
