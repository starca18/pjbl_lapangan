<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h3 class="fw-bold mb-1">Dashboard Pengelola</h3>
    <p class="text-secondary small mb-0">Ringkasan operasional dan reservasi lapangan gelanggang olahraga.</p>
  </div>
  <div class="d-flex gap-2">
    <a href="<?= base_url('admin/jadwal') ?>" class="btn btn-outline-success btn-sm">
      <i class="bi bi-calendar3 me-1"></i>Lihat Master Jadwal
    </a>
    <a href="<?= base_url('admin/bookings/create') ?>" class="btn btn-sport-primary btn-sm">
      <i class="bi bi-plus-lg me-1"></i>Reservasi Walk-in
    </a>
  </div>
</div>

<!-- Metrics Cards -->
<div class="row g-3 mb-4">
  
  <div class="col-xl-3 col-sm-6">
    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <span class="text-secondary small fw-semibold">Booking Hari Ini</span>
          <h3 class="fw-bold text-dark mt-1 mb-0"><?= $todayBookings ?></h3>
          <span class="text-muted small"><?= esc(tanggal_indonesia($today)) ?></span>
        </div>
        <div class="d-inline-flex p-3 rounded-circle bg-success-subtle text-success">
          <i class="bi bi-calendar-check fs-4"></i>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-sm-6">
    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <span class="text-secondary small fw-semibold">Pendapatan Hari Ini</span>
          <h3 class="fw-bold text-success mt-1 mb-0"><?= rupiah($todayRevenue) ?></h3>
          <span class="text-muted small">Status pembayaran lunas</span>
        </div>
        <div class="d-inline-flex p-3 rounded-circle bg-primary-subtle text-primary">
          <i class="bi bi-cash-stack fs-4"></i>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-sm-6">
    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <span class="text-secondary small fw-semibold">Menunggu Verifikasi</span>
          <h3 class="fw-bold text-warning mt-1 mb-0"><?= $pendingBookings ?></h3>
          <span class="text-muted small">Perlu tindakan verifikasi</span>
        </div>
        <div class="d-inline-flex p-3 rounded-circle bg-warning-subtle text-warning">
          <i class="bi bi-hourglass-split fs-4"></i>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-sm-6">
    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <span class="text-secondary small fw-semibold">Total Lapangan Aktif</span>
          <h3 class="fw-bold text-dark mt-1 mb-0"><?= $totalCourts ?></h3>
          <span class="text-muted small">6 cabang olahraga</span>
        </div>
        <div class="d-inline-flex p-3 rounded-circle bg-info-subtle text-info">
          <i class="bi bi-grid-3x3-gap fs-4"></i>
        </div>
      </div>
    </div>
  </div>

</div>

<!-- Quick Overview & Recent Bookings -->
<div class="row g-4">
  
  <div class="col-lg-8">
    <div class="card border-0 shadow-sm rounded-3 bg-white">
      <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0">Reservasi Terbaru Masuk</h5>
        <a href="<?= base_url('admin/bookings') ?>" class="text-success small fw-semibold text-decoration-none">
          Lihat Semua (<?= count($recentBookings) ?>) &rarr;
        </a>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light small text-secondary">
              <tr>
                <th class="ps-3">KODE / TANGGAL</th>
                <th>LAPANGAN</th>
                <th>PEMESAN</th>
                <th>JAM SEWA</th>
                <th>TOTAL</th>
                <th>STATUS</th>
                <th class="text-end pe-3">AKSI</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($recentBookings)): ?>
                <tr>
                  <td colspan="7" class="text-center py-4 text-muted">Belum ada data reservasi.</td>
                </tr>
              <?php else: ?>
                <?php foreach ($recentBookings as $bk): ?>
                  <tr>
                    <td class="ps-3">
                      <div class="font-monospace fw-bold text-dark"><?= esc($bk['booking_code']) ?></div>
                      <div class="small text-muted"><?= esc($bk['booking_date']) ?></div>
                    </td>
                    <td>
                      <div class="fw-semibold text-dark"><?= esc($bk['court_name']) ?></div>
                      <div class="small text-muted"><?= esc($bk['category_name']) ?></div>
                    </td>
                    <td>
                      <div class="fw-semibold text-dark"><?= esc($bk['customer_name']) ?></div>
                      <div class="small text-muted"><?= esc($bk['customer_phone']) ?></div>
                    </td>
                    <td>
                      <span class="badge bg-light text-dark border">
                        <?= substr($bk['start_time'], 0, 5) ?> - <?= substr($bk['end_time'], 0, 5) ?>
                      </span>
                    </td>
                    <td class="fw-bold text-success">
                      <?= rupiah($bk['total_price']) ?>
                    </td>
                    <td>
                      <?= badge_status($bk['status']) ?>
                    </td>
                    <td class="text-end pe-3">
                      <a href="<?= base_url('admin/bookings/detail/' . $bk['id']) ?>" class="btn btn-outline-secondary btn-sm p-1 px-2" title="Detail">
                        <i class="bi bi-eye"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <!-- Quick Status Card -->
    <div class="card border-0 shadow-sm rounded-3 bg-white mb-4">
      <div class="card-header bg-white border-bottom py-3">
        <h5 class="fw-bold mb-0">Papan Jadwal Cepat Hari Ini</h5>
      </div>
      <div class="card-body p-3">
        <p class="text-secondary small mb-3">
          Status okupansi slot lapangan hari ini (<?= tanggal_indonesia($today) ?>):
        </p>

        <div class="d-flex justify-content-between align-items-center p-2.5 bg-light rounded-2 mb-2">
          <span class="small fw-semibold text-secondary">Slot Terisi:</span>
          <span class="badge bg-danger fs-6"><?= $occupiedCount ?> Slot</span>
        </div>

        <div class="d-grid gap-2 mt-3">
          <a href="<?= base_url('admin/jadwal?date=' . $today) ?>" class="btn btn-sport-primary btn-sm py-2">
            <i class="bi bi-calendar3 me-1"></i>Buka Master Jadwal Hari Ini
          </a>
          <a href="<?= base_url('admin/bookings/create') ?>" class="btn btn-outline-secondary btn-sm py-2">
            <i class="bi bi-person-plus me-1"></i>Booking Manual Pelanggan Datang
          </a>
        </div>
      </div>
    </div>

    <!-- Sport Categories Count -->
    <div class="card border-0 shadow-sm rounded-3 bg-white">
      <div class="card-header bg-white border-bottom py-3">
        <h5 class="fw-bold mb-0">Fasilitas Gelanggang</h5>
      </div>
      <div class="card-body p-3">
        <ul class="list-unstyled mb-0 d-flex flex-column gap-2 small">
          <li class="d-flex justify-content-between align-items-center">
            <span><i class="bi bi-dribbble text-success me-2"></i>Futsal</span>
            <span class="badge bg-secondary-subtle text-secondary">2 Lapangan</span>
          </li>
          <li class="d-flex justify-content-between align-items-center">
            <span><i class="bi bi-shield-shaded text-success me-2"></i>Mini Soccer 7v7</span>
            <span class="badge bg-secondary-subtle text-secondary">1 Stadion</span>
          </li>
          <li class="d-flex justify-content-between align-items-center">
            <span><i class="bi bi-lightning-charge text-success me-2"></i>Badminton</span>
            <span class="badge bg-secondary-subtle text-secondary">2 Court BWF</span>
          </li>
          <li class="d-flex justify-content-between align-items-center">
            <span><i class="bi bi-circle-half text-success me-2"></i>Bola Voli</span>
            <span class="badge bg-secondary-subtle text-secondary">1 Hall</span>
          </li>
          <li class="d-flex justify-content-between align-items-center">
            <span><i class="bi bi-circle text-success me-2"></i>Tenis Lapangan</span>
            <span class="badge bg-secondary-subtle text-secondary">1 Hard Court</span>
          </li>
          <li class="d-flex justify-content-between align-items-center">
            <span><i class="bi bi-grid-3x3 text-success me-2"></i>Padel Panoramik</span>
            <span class="badge bg-secondary-subtle text-secondary">2 Lapangan</span>
          </li>
        </ul>
      </div>
    </div>

  </div>

</div>

<?= $this->endSection() ?>
