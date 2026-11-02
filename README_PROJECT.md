# ðŸ† ArenaSport - Aplikasi Reservasi Lapangan Olahraga (CodeIgniter 4)

Aplikasi web sistem reservasi dan pengecekan jadwal lapangan olahraga berbasis **CodeIgniter 4** dan **MySQL/MariaDB**. Dilengkapi dengan visual timetable matrix yang memperlihatkan status ketersediaan jam (slot kosong vs penuh) secara real-time.

---

## âš½ Cabang Olahraga yang Didukung

Aplikasi ini mencakup 6 jenis cabang olahraga lengkap:
1. **Futsal**: Lapangan Vinyl Taraflex & Lapangan Rumput Sintetis.
2. **Mini Soccer**: Stadion Mini Soccer 7 vs 7 Rumput Monofilament.
3. **Badminton**: Court Karpet Vinyl Standar BWF Approved (Matras Hijau & Matras Biru).
4. **Bola Voli**: Aula Indoor Interlocking Polypropylene PBVSI.
5. **Tenis Lapangan**: Hard Court Acrylic Plexipave Outdoor.
6. **Padel**: Lapangan Panoramik Tempered Glass & Mondo Texturized Turf.

---

## âœ¨ Fitur Utama

### 1. Papan Jadwal Ketersediaan Real-Time (Jadwal Penuh vs Kosong)
- **Tampilan Matriks Interaktif**: Kolom jam operasional (07:00 - 23:00) vs baris lapangan.
- **Warna Indikator Ketersediaan**:
  - ðŸŸ¢ **Hijau (Tersedia / Kosong)**: Slot siap dipesan. Klik slot untuk langsung reservasi.
  - ðŸ”´ **Merah (Penuh / Terisi)**: Sudah dipesan oleh pengguna lain.
  - ðŸŸ¡ **Kuning (Proses / Pending)**: Menunggu konfirmasi verifikasi.
- **Filter Tanggal & Olahraga**: Pilih tanggal main (Hari Ini, Besok, Lusa, atau kalender) dan cabang olahraga.
- **Pencegahan Double-Booking (Atomic Slot Lock)**: Sistem database mencegah pemesanan ganda pada jam dan lapangan yang sama.

### 2. Alur Pemesanan Cepat & Fleksibel
- Pilih durasi pemesanan (bisa memilih 1 jam atau beberapa jam beruntun).
- Kalkulasi total biaya sewa otomatis dan real-time.
- Formulir data pemesan dengan nomor WhatsApp aktif.
- Pilihan metode pembayaran: Transfer Bank (BCA, Mandiri), QRIS, atau Tunai di Kasir.

### 3. E-Tiket & Lacak Reservasi
- E-Tiket digital dengan kode booking unik (contoh: `BK-20261102-001`).
- Fitur **Cek / Lacak Booking** untuk memantau status pemesanan.
- Fitur **Cetak Struk / Invoice Reservasi**.
- Tombol konfirmasi otomatis ke WhatsApp Admin.

### 4. Panel Admin & Manajemen Lapangan
- **Dashboard Statistik**: Total pendapatan, booking hari ini, booking pending, dan grafik fasilitas.
- **Master Jadwal Admin**: Melihat nama pemesan di setiap slot terisi, dan input cepat booking walk-in untuk pelanggan yang datang langsung.
- **Kelola Reservasi**: Ubah status (Konfirmasi, Selesai, Batalkan) dan status pembayaran (Lunas, DP, Belum Lunas).
- **Kelola Lapangan (CRUD)**: Tambah, edit, nonaktifkan (maintenance), dan hapus lapangan.

---

## ðŸš€ Panduan Akses & Penggunaan

### 1. URL Akses Aplikasi
- **Halaman Utama / Publik**:
  - `http://localhost/pjbl_lapangan/`
  - atau `http://localhost/pjbl_lapangan/public/`
- **Papan Jadwal Ketersediaan**:
  - `http://localhost/pjbl_lapangan/public/jadwal`
- **Pilih & Reservasi Lapangan**:
  - `http://localhost/pjbl_lapangan/public/booking`
- **Lacak Kode Booking**:
  - `http://localhost/pjbl_lapangan/public/lacak`
- **Login Admin / Staff**:
  - `http://localhost/pjbl_lapangan/public/login`

### 2. Akun Administrator Demo (Ubah saat Produksi)
- **Username**: `admin`
- **Password**: `admin123`

---

## ðŸ› ï¸ Konfigurasi & Struktur Database

- **Nama Database**: `pjbl_lapangan`
- **File Konfigurasi**: `.env`
- **File Dump SQL**: `database.sql` (bisa diimport via phpMyAdmin jika diperlukan)
- **Perintah CLI Spark** (opsional):
  ```bash
  # Menjalankan migrasi database
  php spark migrate

  # Menjalankan seeder data awal
  php spark db:seed ReservationSeeder
  ```
