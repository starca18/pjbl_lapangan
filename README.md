# 🏟️ ArenaSport — Sistem Reservasi Lapangan Olahraga

Aplikasi web sistem reservasi dan pemesanan lapangan olahraga terintegrasi berbasis **CodeIgniter 4** dan **MySQL/MariaDB** dengan tampilan visual jadwal real-time dan animasi interaktif isometrik cabang olahraga.

Dibuat untuk tugas Project-Based Learning (PJBL) Reservasi Lapangan.

🌐 **Live Demo (Hosting):** [http://pjbl-kelompok3-arenasport.site.je/](http://pjbl-kelompok3-arenasport.site.je/)

---

## ✨ Fitur Utama

1. **6 Pilihan Cabang Olahraga:**
   - ⚽ **Futsal:** Lapangan Vinyl & Rumput Sintetis (5 vs 5)
   - ⚽ **Mini Soccer:** Lapangan Rumput Sintetis Standar Bintang 2 (7 vs 7)
   - 🏸 **Badminton:** Lapangan Karpet BWF (Tunggal & Ganda)
   - 🏐 **Bola Voli:** Lapangan Indoor Kayu (6 vs 6)
   - 🎾 **Tenis:** Lapangan Hard Court Standar ITF
   - 🎾 **Padel:** Lapangan Panoramic Dinding Kaca Tempered

2. **Papan Jadwal Real-Time (Timetable Matrix):**
   - Menampilkan status slot jam operasional (07:00 – 23:00 WIB).
   - Indikator warna transparan:
     - 🟢 **Hijau (Kosong):** Slot tersedia dan dapat langsung diklik untuk reservasi.
     - 🔴 **Merah (Penuh):** Slot telah terisi / dipesan.
     - 🟡 **Kuning (Proses):** Menunggu konfirmasi pembayaran.
   - Filter cepat berdasarkan tanggal (Hari Ini, Besok, Lusa, Custom Date) dan cabang olahraga.

3. **Animasi Lapangan Isometrik Interaktif:**
   - Animasi vektor SVG murni dengan fisika gerak pemain (menendang, servis, smash, diving kiper, ayunan raket, dan pantulan bola/kok).
   - Aktif saat diarahkan kursor (*hover*) di laptop atau disentuh (*touch*) di layar smartphone.

4. **Sistem Pemesanan & Pencegahan Double-Booking:**
   - Pemilihan jam fleksibel (multi-slot dalam 1 kali transaksi).
   - Penguncian atomik di database tabel `booking_slots` dengan *unique composite key* (`court_id`, `booking_date`, `slot_time`) sehingga mustahil terjadi tabrakan jadwal.
   - Perhitungan total biaya otomatis berdasarkan durasi jam dan tarif sewa per lapangan.

5. **E-Tiket & Lacak Kode Booking:**
   - Menghasilkan struk / e-tiket resmi siap tunjuk di kasir.
   - Pencarian riwayat reservasi pelanggan via halaman `/lacak` menggunakan kode booking.

6. **Panel Manajemen Administrator:**
   - Dashboard ringkasan metrik (Total Reservasi, Pendapatan, Lapangan Aktif, Booking Hari Ini).
   - Master Papan Jadwal Admin untuk input reservasi walk-in secara langsung.
   - Kelola Data Reservasi (konfirmasi bayar, batalkan, cetak PDF/struk).
   - CRUD Data Lapangan (tambah, edit harga, jenis lantai, status indoor/outdoor).

7. **Desain Mobile-First & Responsif:**
   - Palet warna energik oranye vibrant (`#f97316`) dan dark warm.
   - Tampilan adaptif di berbagai resolusi layar mulai dari smartphone 375px hingga monitor desktop.

---

## 🛠️ Tech Stack

- **Backend:** PHP 8.2+ (Framework CodeIgniter 4.7.x)
- **Database:** MariaDB / MySQL 8.x
- **Frontend:** Bootstrap 5.3.3, Bootstrap Icons 1.11.3, Google Fonts (*Plus Jakarta Sans*)
- **Animasi:** Pure CSS Keyframes & SVG Isometric Geometry
- **Web Server:** Apache / Nginx / XAMPP

---

## 🚀 Panduan Instalasi Lokal (XAMPP)

### 1. Clone Repository
```bash
git clone https://github.com/starca18/pjbl_lapangan.git
cd pjbl_lapangan
```

### 2. Install Dependency Composer
```bash
composer install
```

### 3. Buat Database & Import SQL
1. Buka phpMyAdmin di browser: `http://localhost/phpmyadmin/`
2. Buat database baru bernama `pjbl_lapangan`.
3. Import file `database.sql` yang berada di root repository.

### 4. Konfigurasi Environment (`.env`)
Salin file `env.example` menjadi `.env`:
```bash
cp env.example .env
```
Sesuaikan konfigurasi koneksi database:
```ini
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost/pjbl_lapangan/public/'
app.indexPage = ''
app.appTimezone = 'Asia/Jakarta'

database.default.hostname = localhost
database.default.database = pjbl_lapangan
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
database.default.port = 3306
```

### 5. Jalankan Aplikasi
Akses via web server lokal Anda:
```
http://localhost/pjbl_lapangan/public/
```
Atau gunakan PHP CLI development server bawaan CodeIgniter:
```bash
php spark serve
```
Buka browser pada: `http://localhost:8080`

---

## 🔐 Akun Default Admin

- **URL Login:** `http://localhost/pjbl_lapangan/public/login`
- **Username:** `admin`
- **Password:** `admin123`

---

## 👥 Pengembang

- **Repository:** [https://github.com/starca18/pjbl_lapangan](https://github.com/starca18/pjbl_lapangan)
- **Tugas:** Project-Based Learning (PJBL) Rekayasa Perangkat Lunak / Web Development
