<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="mb-4">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-1 small">
      <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="<?= base_url('admin/bookings') ?>">Reservasi</a></li>
      <li class="breadcrumb-item active" aria-current="page"><?= esc($booking['booking_code']) ?></li>
    </ol>
  </nav>
  <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">
    <div>
      <h3 class="fw-bold mb-0">Detail Reservasi: <span class="font-monospace text-success"><?= esc($booking['booking_code']) ?></span></h3>
      <div class="small text-muted">Dibuat pada: <?= date('d/m/Y H:i:s', strtotime($booking['created_at'])) ?></div>
    </div>
    <div class="d-flex gap-2">
      <a href="<?= base_url('admin/bookings/print/' . $booking['id']) ?>" target="_blank" class="btn btn-outline-dark btn-sm">
        <i class="bi bi-printer me-1"></i>Cetak Struk
      </a>
      <a href="<?= base_url('admin/bookings') ?>" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Kembali
      </a>
    </div>
  </div>
</div>

<div class="row g-4">
  <div class="col-lg-8">
    <div class="card border-0 shadow-sm rounded-3 p-4 bg-white mb-4">
      <h5 class="fw-bold mb-3 border-bottom pb-2">Informasi Pemesanan & Lapangan</h5>

      <div class="row g-3 mb-4">
        <div class="col-sm-6">
          <div class="text-secondary small">Nama Lapangan:</div>
          <div class="fw-bold text-dark fs-5"><?= esc($booking['court_name']) ?></div>
          <div class="small text-muted"><?= esc($booking['category_name']) ?> &bull; <?= esc($booking['court_type']) ?></div>
        </div>

        <div class="col-sm-6">
          <div class="text-secondary small">Tanggal Main:</div>
          <div class="fw-bold text-dark fs-5"><?= tanggal_indonesia($booking['booking_date']) ?></div>
        </div>

        <div class="col-sm-6">
          <div class="text-secondary small">Jam Sewa:</div>
          <div class="fw-bold text-dark">
            <?= substr($booking['start_time'], 0, 5) ?> - <?= substr($booking['end_time'], 0, 5) ?> WIB
            <span class="badge bg-secondary-subtle text-secondary ms-1"><?= $booking['total_hours'] ?> Jam</span>
          </div>
        </div>

        <div class="col-sm-6">
          <div class="text-secondary small">Lantai Lapangan:</div>
          <div class="text-dark fw-semibold"><?= esc($booking['floor_type'] ?? '-') ?></div>
        </div>
      </div>

      <h5 class="fw-bold mb-3 border-bottom pb-2">Data Pemesan</h5>
      <div class="row g-3 mb-4">
        <div class="col-sm-6">
          <div class="text-secondary small">Nama Lengkap / Tim:</div>
          <div class="fw-bold text-dark"><?= esc($booking['customer_name']) ?></div>
        </div>

        <div class="col-sm-6">
          <div class="text-secondary small">Nomor WhatsApp:</div>
          <div class="text-dark fw-semibold">
            <?= esc($booking['customer_phone']) ?>
            <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $booking['customer_phone']) ?>" target="_blank" class="badge bg-success-subtle text-success text-decoration-none ms-1">
              <i class="bi bi-whatsapp"></i> Chat
            </a>
          </div>
        </div>

        <div class="col-sm-6">
          <div class="text-secondary small">Email:</div>
          <div class="text-dark"><?= esc($booking['customer_email'] ?: '-') ?></div>
        </div>

        <div class="col-sm-6">
          <div class="text-secondary small">Catatan Tambahan:</div>
          <div class="text-dark"><?= esc($booking['notes'] ?: '-') ?></div>
        </div>
      </div>

      <h5 class="fw-bold mb-3 border-bottom pb-2">Rincian Slot Jam Terkunci (Atomic)</h5>
      <div class="d-flex flex-wrap gap-2">
        <?php if (empty($slots)): ?>
          <span class="text-danger small fst-italic">Slot waktu dilepaskan (reservasi dibatalkan).</span>
        <?php else: ?>
          <?php foreach ($slots as $s): ?>
            <span class="badge bg-light text-dark border px-3 py-2">
              <i class="bi bi-clock me-1 text-success"></i><?= substr($s['slot_time'], 0, 5) ?> WIB
            </span>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <!-- Status Management Card -->
    <div class="card border-0 shadow-sm rounded-3 p-4 bg-white mb-4">
      <h5 class="fw-bold mb-3 border-bottom pb-2">Status & Pembayaran</h5>

      <form action="<?= base_url('admin/bookings/update-status/' . $booking['id']) ?>" method="post">
        <?= csrf_field() ?>

        <div class="mb-3">
          <label class="form-label small fw-bold text-secondary">Status Reservasi:</label>
          <select name="status" class="form-select">
            <option value="confirmed" <?= $booking['status'] === 'confirmed' ? 'selected' : '' ?>>Terkonfirmasi (Confirmed)</option>
            <option value="pending" <?= $booking['status'] === 'pending' ? 'selected' : '' ?>>Menunggu Verifikasi (Pending)</option>
            <option value="completed" <?= $booking['status'] === 'completed' ? 'selected' : '' ?>>Selesai Digunakan (Completed)</option>
            <option value="cancelled" <?= $booking['status'] === 'cancelled' ? 'selected' : '' ?>>Dibatalkan (Cancelled)</option>
          </select>
          <div class="form-text small">Jika dibatalkan, slot jam akan otomatis dilepas kembali ke publik.</div>
        </div>

        <div class="mb-3">
          <label class="form-label small fw-bold text-secondary">Status Pembayaran:</label>
          <select name="payment_status" class="form-select">
            <option value="paid" <?= $booking['payment_status'] === 'paid' ? 'selected' : '' ?>>Lunas (Paid)</option>
            <option value="dp" <?= $booking['payment_status'] === 'dp' ? 'selected' : '' ?>>Uang Muka (DP)</option>
            <option value="unpaid" <?= $booking['payment_status'] === 'unpaid' ? 'selected' : '' ?>>Belum Lunas (Unpaid)</option>
          </select>
        </div>

        <div class="mb-3">
          <div class="text-secondary small">Metode Bayar:</div>
          <div class="fw-bold text-dark"><?= esc($booking['payment_method']) ?></div>
        </div>

        <div class="mb-4">
          <div class="text-secondary small">Total Tagihan:</div>
          <div class="fw-bold fs-3 text-success"><?= rupiah($booking['total_price']) ?></div>
        </div>

        <button type="submit" class="btn btn-sport-primary w-100 py-2 fw-semibold">
          <i class="bi bi-arrow-repeat me-1"></i>Simpan Perubahan Status
        </button>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
