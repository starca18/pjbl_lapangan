<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<!-- Dashboard Page Header -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
  <div>
    <h3 class="fw-bold mb-1 text-dark">Dashboard Operasional</h3>
    <p class="text-secondary small mb-0">Monitoring ketersediaan slot lapangan, verifikasi pembayaran, dan reservasi hari ini.</p>
  </div>
  <div class="d-flex flex-wrap gap-2">
    <a href="<?= base_url('admin/jadwal') ?>" class="btn btn-outline-secondary btn-sm px-3.5 py-1.5 rounded-pill fw-medium d-inline-flex align-items-center" style="gap: 8px;">
      <i class="bi bi-calendar3-week"></i>
      <span>Master Jadwal</span>
    </a>
    <a href="<?= base_url('admin/bookings/create') ?>" class="btn btn-sport-primary btn-sm px-4 py-1.5 rounded-pill shadow-sm fw-semibold d-inline-flex align-items-center" style="gap: 8px;">
      <i class="bi bi-plus-lg"></i>
      <span>Reservasi Walk-in</span>
    </a>
  </div>
</div>

<!-- Pending Verification Alert Banner (Actionable Alert) -->
<?php if (!empty($pendingBookings) && $pendingBookings > 0): ?>
  <div class="card border-0 mb-4 rounded-3 shadow-sm" style="background: linear-gradient(90deg, #fffbeb 0%, #fef3c7 100%); border-left: 4px solid #f59e0b !important;">
    <div class="card-body p-3 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center" style="gap: 16px;">
      <div class="d-flex align-items-center" style="gap: 14px;">
        <div class="d-inline-flex align-items-center justify-content-center rounded-circle text-amber-700 bg-white shadow-xs" style="width:42px;height:42px;min-width:42px;color:#d97706;">
          <i class="bi bi-hourglass-split fs-5"></i>
        </div>
        <div>
          <div class="fw-bold text-dark mb-0.5">Ada <?= $pendingBookings ?> Reservasi Menunggu Verifikasi Pembayaran</div>
          <div class="text-secondary small">Segera periksa bukti transfer pelanggan untuk mengunci slot lapangan.</div>
        </div>
      </div>
      <a href="<?= base_url('admin/bookings') ?>" class="btn btn-sm btn-dark text-nowrap rounded-pill px-3.5 fw-semibold align-self-start align-self-sm-center d-inline-flex align-items-center" style="gap: 6px;">
        <span>Periksa Sekarang</span>
        <i class="bi bi-arrow-right"></i>
      </a>
    </div>
  </div>
<?php endif; ?>

<!-- 4 Key Metric Cards (Refined Precision Cards) -->
<div class="row g-3 mb-4">
  
  <!-- Metric 1: Bookings Today -->
  <div class="col-xl-3 col-sm-6">
    <div class="card border-0 shadow-sm rounded-3 bg-white h-100 p-3">
      <div class="d-flex justify-content-between align-items-start mb-2">
        <span class="text-secondary small fw-semibold">Booking Hari Ini</span>
        <span class="d-inline-flex p-2 rounded-2 bg-light text-secondary">
          <i class="bi bi-calendar-check fs-5"></i>
        </span>
      </div>
      <div class="d-flex align-items-baseline gap-2 mb-1">
        <h2 class="fw-bold text-dark mb-0 font-monospace" style="font-size:2rem;"><?= $todayBookings ?></h2>
        <span class="text-secondary small">Slot</span>
      </div>
      <div class="text-muted small pt-2 border-top mt-2 d-flex justify-content-between align-items-center">
        <span>Terkonfirmasi</span>
        <span class="fw-semibold text-dark">Hari Ini</span>
      </div>
    </div>
  </div>

  <!-- Metric 2: Today Revenue -->
  <div class="col-xl-3 col-sm-6">
    <div class="card border-0 shadow-sm rounded-3 bg-white h-100 p-3">
      <div class="d-flex justify-content-between align-items-start mb-2">
        <span class="text-secondary small fw-semibold">Pendapatan Hari Ini</span>
        <span class="d-inline-flex p-2 rounded-2 bg-light text-secondary">
          <i class="bi bi-wallet2 fs-5"></i>
        </span>
      </div>
      <div class="d-flex align-items-baseline gap-1 mb-1">
        <h2 class="fw-bold text-dark mb-0 font-monospace" style="font-size:1.65rem; color:#0f172a;"><?= rupiah($todayRevenue) ?></h2>
      </div>
      <div class="text-muted small pt-2 border-top mt-2 d-flex justify-content-between align-items-center">
        <span>Total Semua:</span>
        <span class="fw-semibold text-dark"><?= rupiah($totalRevenue) ?></span>
      </div>
    </div>
  </div>

  <!-- Metric 3: Pending Verification -->
  <div class="col-xl-3 col-sm-6">
    <div class="card border-0 shadow-sm rounded-3 bg-white h-100 p-3" style="<?= $pendingBookings > 0 ? 'border: 1px solid #fde68a !important; background:#fffdfa;' : '' ?>">
      <div class="d-flex justify-content-between align-items-start mb-2">
        <span class="text-secondary small fw-semibold">Menunggu Verifikasi</span>
        <span class="d-inline-flex p-2 rounded-2 <?= $pendingBookings > 0 ? 'bg-warning-subtle text-warning' : 'bg-light text-secondary' ?>">
          <i class="bi bi-clock-history fs-5"></i>
        </span>
      </div>
      <div class="d-flex align-items-baseline gap-2 mb-1">
        <h2 class="fw-bold mb-0 font-monospace <?= $pendingBookings > 0 ? 'text-warning' : 'text-dark' ?>" style="font-size:2rem;"><?= $pendingBookings ?></h2>
        <span class="text-secondary small">Reservasi</span>
      </div>
      <div class="text-muted small pt-2 border-top mt-2 d-flex justify-content-between align-items-center">
        <span>Status:</span>
        <span class="<?= $pendingBookings > 0 ? 'text-warning fw-bold' : 'text-success fw-medium' ?>">
          <?= $pendingBookings > 0 ? 'Perlu Diproses' : 'Semua Bersih' ?>
        </span>
      </div>
    </div>
  </div>

  <!-- Metric 4: Okupansi Hari Ini -->
  <div class="col-xl-3 col-sm-6">
    <div class="card border-0 shadow-sm rounded-3 bg-white h-100 p-3">
      <div class="d-flex justify-content-between align-items-start mb-2">
        <span class="text-secondary small fw-semibold">Okupansi Hari Ini</span>
        <span class="d-inline-flex p-2 rounded-2 bg-light text-secondary">
          <i class="bi bi-speedometer2 fs-5"></i>
        </span>
      </div>
      <div class="d-flex align-items-baseline gap-2 mb-1">
        <h2 class="fw-bold text-dark mb-0 font-monospace" style="font-size:2rem;"><?= $occupancyRate ?>%</h2>
        <span class="text-secondary small font-monospace"><?= $occupiedCount ?> / <?= $totalCapacity ?> Slot</span>
      </div>
      <div class="pt-2 border-top mt-2">
        <div class="progress" style="height: 6px; border-radius: 4px; background-color: #f1f5f9;">
          <div class="progress-bar" role="progressbar" style="width: <?= $occupancyRate ?>%; background-color: var(--sport-primary);" aria-valuenow="<?= $occupancyRate ?>" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
      </div>
    </div>
  </div>

</div>

<!-- Main Operational Layout: Table & Side Widgets -->
<div class="row g-4">
  
  <!-- Left Column: Recent Bookings Table (Col 8) -->
  <div class="col-xl-8 col-lg-7">
    <div class="card border-0 shadow-sm rounded-3 bg-white overflow-hidden">
      <div class="card-header bg-white border-bottom py-3 px-3 px-md-4 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center" style="gap: 10px;">
          <h5 class="fw-bold mb-0 text-dark">Reservasi Terbaru Masuk</h5>
          <span class="badge bg-secondary-subtle text-secondary rounded-pill"><?= count($recentBookings) ?> Data</span>
        </div>
        <a href="<?= base_url('admin/bookings') ?>" class="text-secondary small fw-semibold text-decoration-none d-flex align-items-center hover-primary" style="gap: 6px;">
          <span>Lihat Semua</span>
          <i class="bi bi-arrow-right"></i>
        </a>
      </div>

      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0" style="font-size:0.875rem;">
            <thead class="table-light text-secondary small fw-bold text-uppercase" style="letter-spacing:0.04em; font-size:0.75rem;">
              <tr>
                <th class="ps-3 ps-md-4 py-3" style="width:160px;">Kode / Tanggal</th>
                <th class="py-3">Lapangan</th>
                <th class="py-3">Pemesan</th>
                <th class="py-3" style="white-space:nowrap;">Jam Sewa</th>
                <th class="py-3">Total</th>
                <th class="py-3 text-center">Status</th>
                <th class="py-3 text-end pe-3 pe-md-4" style="width:80px;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($recentBookings)): ?>
                <tr>
                  <td colspan="7" class="text-center py-5 text-muted">
                    <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary"></i>
                    Belum ada data reservasi masuk.
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($recentBookings as $bk): ?>
                  <tr>
                    <td class="ps-3 ps-md-4 py-3">
                      <span class="badge bg-light text-dark font-monospace border px-2 py-1 text-nowrap" style="font-size:0.78rem;">
                        <?= esc($bk['booking_code']) ?>
                      </span>
                      <div class="text-muted small mt-1 d-flex align-items-center" style="font-size:0.75rem; white-space:nowrap; gap:5px;">
                        <i class="bi bi-calendar-event"></i>
                        <span><?= esc($bk['booking_date']) ?></span>
                      </div>
                    </td>
                    <td class="py-3">
                      <div class="fw-bold text-dark text-nowrap"><?= esc($bk['court_name']) ?></div>
                      <span class="badge bg-secondary-subtle text-secondary small" style="font-size:0.7rem; font-weight:500;">
                        <?= esc($bk['category_name']) ?>
                      </span>
                    </td>
                    <td class="py-3">
                      <div class="fw-semibold text-dark text-nowrap"><?= esc($bk['customer_name']) ?></div>
                      <?php 
                        $rawPhone = preg_replace('/[^0-9]/', '', $bk['customer_phone'] ?? '');
                        if (str_starts_with($rawPhone, '0')) {
                          $rawPhone = '62' . substr($rawPhone, 1);
                        }
                      ?>
                      <a href="https://wa.me/<?= $rawPhone ?>" target="_blank" class="text-secondary small text-decoration-none d-inline-flex align-items-center" style="gap: 6px;" title="Kirim Pesan WhatsApp">
                        <i class="bi bi-whatsapp text-success" style="font-size:0.8rem;"></i>
                        <span style="font-size:0.78rem;"><?= esc($bk['customer_phone']) ?></span>
                      </a>
                    </td>
                    <td class="py-3" style="white-space:nowrap;">
                      <span class="badge bg-light text-dark border px-2.5 py-1 font-monospace d-inline-flex align-items-center" style="font-size:0.78rem; gap:6px;">
                        <i class="bi bi-clock text-secondary"></i>
                        <span><?= substr($bk['start_time'], 0, 5) ?> - <?= substr($bk['end_time'], 0, 5) ?></span>
                      </span>
                    </td>
                    <td class="py-3 text-nowrap fw-bold text-dark font-monospace">
                      <?= rupiah($bk['total_price']) ?>
                    </td>
                    <td class="py-3 text-center text-nowrap">
                      <?= badge_status($bk['status']) ?>
                    </td>
                    <td class="py-3 text-end pe-3 pe-md-4">
                      <a href="<?= base_url('admin/bookings/detail/' . $bk['id']) ?>" class="btn btn-sm btn-outline-secondary px-2.5 py-1 rounded-2" title="Lihat Detail Reservasi">
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

  <!-- Right Column: Operations Widgets (Col 4) -->
  <div class="col-xl-4 col-lg-5">
    
    <!-- Widget 1: Today Occupancy & Fast Actions -->
    <div class="card border-0 shadow-sm rounded-3 bg-white mb-4 p-3.5">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0 text-dark d-flex align-items-center" style="gap: 8px;">
          <i class="bi bi-bar-chart-line text-primary"></i>
          <span>Okupansi Gelanggang</span>
        </h6>
        <span class="badge bg-light text-secondary border small">Hari Ini</span>
      </div>

      <div class="p-3 bg-light rounded-3 mb-3">
        <div class="d-flex justify-content-between align-items-baseline mb-2">
          <span class="small text-secondary">Status Pemakaian:</span>
          <span class="fw-bold text-dark font-monospace"><?= $occupiedCount ?> / <?= $totalCapacity ?> Slot (<?= $occupancyRate ?>%)</span>
        </div>
        <div class="progress mb-2" style="height: 8px; border-radius: 4px;">
          <div class="progress-bar" style="width: <?= $occupancyRate ?>%; background-color: var(--sport-primary);"></div>
        </div>
        <div class="d-flex justify-content-between text-muted small" style="font-size:0.75rem;">
          <span class="d-inline-flex align-items-center" style="gap:4px;"><i class="bi bi-circle-fill text-danger" style="font-size:0.45rem;"></i>Terisi: <?= $occupiedCount ?></span>
          <span class="d-inline-flex align-items-center" style="gap:4px;"><i class="bi bi-circle-fill text-success" style="font-size:0.45rem;"></i>Tersedia: <?= max(0, $totalCapacity - $occupiedCount) ?></span>
          <span class="d-inline-flex align-items-center" style="gap:4px;"><i class="bi bi-circle-fill text-secondary" style="font-size:0.45rem;"></i>Lapangan: <?= $totalCourts ?></span>
        </div>
      </div>

      <div class="d-grid gap-2">
        <a href="<?= base_url('admin/jadwal?date=' . $today) ?>" class="btn btn-outline-dark btn-sm py-2 rounded-2 fw-medium d-inline-flex align-items-center justify-content-center" style="gap: 8px;">
          <i class="bi bi-calendar3"></i>
          <span>Buka Papan Jadwal Hari Ini</span>
        </a>
        <a href="<?= base_url('admin/bookings/create') ?>" class="btn btn-sport-primary btn-sm py-2 rounded-2 fw-medium d-inline-flex align-items-center justify-content-center" style="gap: 8px;">
          <i class="bi bi-person-plus"></i>
          <span>Input Booking Walk-in</span>
        </a>
      </div>
    </div>

    <!-- Widget 2: Dynamic Facility Summary -->
    <div class="card border-0 shadow-sm rounded-3 bg-white p-3.5">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0 text-dark d-flex align-items-center" style="gap: 8px;">
          <i class="bi bi-grid-fill text-secondary"></i>
          <span>Fasilitas Gelanggang</span>
        </h6>
        <a href="<?= base_url('admin/courts') ?>" class="small text-secondary text-decoration-none fw-semibold">Kelola &rarr;</a>
      </div>

      <div class="d-flex flex-column gap-2">
        <?php foreach ($categories as $cat): ?>
          <div class="d-flex justify-content-between align-items-center p-2 rounded-2 bg-light hover-bg-subtle">
            <div class="d-flex align-items-center" style="gap: 10px;">
              <span class="d-inline-flex align-items-center justify-content-center rounded-2 bg-white border text-secondary" style="width:30px;height:30px;font-size:0.85rem;">
                <i class="bi <?= esc($cat['icon']) ?>"></i>
              </span>
              <div>
                <div class="fw-semibold text-dark small lh-sm"><?= esc($cat['name']) ?></div>
                <div class="text-muted small" style="font-size:0.72rem;">Mulai <?= rupiah($cat['min_price'] ?? 0) ?></div>
              </div>
            </div>
            <span class="badge bg-white text-dark border font-monospace">
              <?= esc($cat['courts_count'] ?? 0) ?> Lapangan
            </span>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

  </div>

</div>

<?= $this->endSection() ?>
