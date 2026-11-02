<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
  <div>
    <h3 class="fw-bold mb-1">Daftar Seluruh Reservasi</h3>
    <p class="text-secondary small mb-0">Kelola konfirmasi, pembatalan, pembayaran, dan pencetakan bukti booking.</p>
  </div>
  <a href="<?= base_url('admin/bookings/create') ?>" class="btn btn-sport-primary btn-sm">
    <i class="bi bi-plus-circle me-1"></i>Tambah Booking Manual
  </a>
</div>

<!-- Filters Card -->
<div class="card border-0 shadow-sm rounded-3 p-3 bg-white mb-4">
  <form action="<?= base_url('admin/bookings') ?>" method="get" class="row g-2 align-items-end">
    <div class="col-md-3 col-sm-6">
      <label class="form-label small fw-bold text-secondary">Cari Kode / Pemesan:</label>
      <input type="text" name="q" class="form-control form-control-sm" placeholder="Ketik kata kunci..." value="<?= esc($filters['search'] ?? '') ?>">
    </div>

    <div class="col-md-2 col-sm-6">
      <label class="form-label small fw-bold text-secondary">Tanggal Main:</label>
      <input type="date" name="date" class="form-control form-control-sm" value="<?= esc($filters['date'] ?? '') ?>">
    </div>

    <div class="col-md-3 col-sm-6">
      <label class="form-label small fw-bold text-secondary">Pilih Lapangan:</label>
      <select name="court_id" class="form-select form-select-sm">
        <option value="">Semua Lapangan</option>
        <?php foreach ($courts as $c): ?>
          <option value="<?= $c['id'] ?>" <?= ($filters['court_id'] ?? '') == $c['id'] ? 'selected' : '' ?>>
            <?= esc($c['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-2 col-sm-6">
      <label class="form-label small fw-bold text-secondary">Status Booking:</label>
      <select name="status" class="form-select form-select-sm">
        <option value="">Semua Status</option>
        <option value="confirmed" <?= ($filters['status'] ?? '') === 'confirmed' ? 'selected' : '' ?>>Terkonfirmasi</option>
        <option value="pending" <?= ($filters['status'] ?? '') === 'pending' ? 'selected' : '' ?>>Menunggu</option>
        <option value="completed" <?= ($filters['status'] ?? '') === 'completed' ? 'selected' : '' ?>>Selesai</option>
        <option value="cancelled" <?= ($filters['status'] ?? '') === 'cancelled' ? 'selected' : '' ?>>Dibatalkan</option>
      </select>
    </div>

    <div class="col-md-2 col-sm-12 d-flex gap-2">
      <button type="submit" class="btn btn-sport-primary btn-sm flex-grow-1">
        <i class="bi bi-funnel me-1"></i>Filter
      </button>
      <a href="<?= base_url('admin/bookings') ?>" class="btn btn-outline-secondary btn-sm" title="Reset">
        <i class="bi bi-arrow-counterclockwise"></i>
      </a>
    </div>
  </form>
</div>

<!-- Bookings Table -->
<div class="card border-0 shadow-sm rounded-3 bg-white overflow-hidden">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light small text-secondary">
        <tr>
          <th class="ps-3">KODE / TGL BUAT</th>
          <th>LAPANGAN</th>
          <th>TANGGAL & JAM SEWA</th>
          <th>DATA PEMESAN</th>
          <th>TAGIHAN & BAYAR</th>
          <th>STATUS</th>
          <th class="text-end pe-3">AKSI</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($bookings)): ?>
          <tr>
            <td colspan="7" class="text-center py-5 text-muted">
              <i class="bi bi-inbox fs-2 d-block mb-2"></i>
              Tidak ada data reservasi yang ditemukan.
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($bookings as $b): ?>
            <tr>
              <td class="ps-3">
                <a href="<?= base_url('admin/bookings/detail/' . $b['id']) ?>" class="font-monospace fw-bold text-success text-decoration-none">
                  <?= esc($b['booking_code']) ?>
                </a>
                <div class="small text-muted"><?= date('d/m/Y H:i', strtotime($b['created_at'])) ?></div>
              </td>

              <td>
                <div class="fw-semibold text-dark"><?= esc($b['court_name']) ?></div>
                <div class="small text-muted"><?= esc($b['category_name']) ?></div>
              </td>

              <td>
                <div class="fw-semibold text-dark"><?= tanggal_indonesia($b['booking_date']) ?></div>
                <div class="small text-muted">
                  <i class="bi bi-clock me-1 text-primary"></i>
                  <?= substr($b['start_time'], 0, 5) ?> - <?= substr($b['end_time'], 0, 5) ?> WIB 
                  <span class="badge bg-light text-secondary border ms-1"><?= $b['total_hours'] ?> Jam</span>
                </div>
              </td>

              <td>
                <div class="fw-semibold text-dark"><?= esc($b['customer_name']) ?></div>
                <div class="small text-muted"><?= esc($b['customer_phone']) ?></div>
              </td>

              <td>
                <div class="fw-bold text-dark"><?= rupiah($b['total_price']) ?></div>
                <div class="mt-0.5"><?= badge_payment($b['payment_status']) ?></div>
              </td>

              <td>
                <div><?= badge_status($b['status']) ?></div>
              </td>

              <td class="text-end pe-3">
                <div class="btn-group btn-group-sm">
                  <a href="<?= base_url('admin/bookings/detail/' . $b['id']) ?>" class="btn btn-outline-secondary" title="Detail & Ubah Status">
                    <i class="bi bi-pencil-square"></i>
                  </a>
                  <a href="<?= base_url('admin/bookings/print/' . $b['id']) ?>" target="_blank" class="btn btn-outline-secondary" title="Cetak Struk">
                    <i class="bi bi-printer"></i>
                  </a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?= $this->endSection() ?>
