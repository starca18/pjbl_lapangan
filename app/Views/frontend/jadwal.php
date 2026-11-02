<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="bg-white border-bottom py-4">
  <div class="container">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
      <div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-1 small">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Papan Jadwal</li>
          </ol>
        </nav>
        <h2 class="fw-bold mb-0">Papan Jadwal Ketersediaan Lapangan</h2>
        <p class="text-secondary small mb-0">
          Pantau status jam yang penuh (merah) dan jam yang masih tersedia (hijau) secara real-time.
        </p>
      </div>

      <!-- Quick Date Shortcuts -->
      <div class="d-flex gap-2">
        <?php 
          $today = date('Y-m-d');
          $tomorrow = date('Y-m-d', strtotime('+1 day'));
          $dayAfter = date('Y-m-d', strtotime('+2 days'));
        ?>
        <a href="<?= base_url('jadwal?date=' . $today . ($selectedCategory ? '&category=' . $selectedCategory : '')) ?>" 
           class="btn btn-sm <?= $selectedDate === $today ? 'btn-success' : 'btn-outline-secondary' ?>">
          Hari Ini
        </a>
        <a href="<?= base_url('jadwal?date=' . $tomorrow . ($selectedCategory ? '&category=' . $selectedCategory : '')) ?>" 
           class="btn btn-sm <?= $selectedDate === $tomorrow ? 'btn-success' : 'btn-outline-secondary' ?>">
          Besok
        </a>
        <a href="<?= base_url('jadwal?date=' . $dayAfter . ($selectedCategory ? '&category=' . $selectedCategory : '')) ?>" 
           class="btn btn-sm <?= $selectedDate === $dayAfter ? 'btn-success' : 'btn-outline-secondary' ?>">
          Lusa
        </a>
      </div>
    </div>
  </div>
</div>

<div class="container py-4">
  
  <!-- Filter Controls Card -->
  <div class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-body p-3 p-md-4">
      <form action="<?= base_url('jadwal') ?>" method="get" class="row g-3 align-items-end">
        <div class="col-lg-3 col-md-4">
          <label class="form-label small fw-bold text-secondary">
            <i class="bi bi-calendar3 me-1 text-success"></i>Pilih Tanggal:
          </label>
          <input type="date" name="date" class="form-control" value="<?= esc($selectedDate) ?>" min="<?= date('Y-m-d') ?>" onchange="this.form.submit()">
        </div>

        <div class="col-lg-4 col-md-4">
          <label class="form-label small fw-bold text-secondary">
            <i class="bi bi-filter me-1 text-success"></i>Cabang Olahraga:
          </label>
          <select name="category" class="form-select" onchange="this.form.submit()">
            <option value="">Semua Olahraga (Futsal, Badminton, Padel, dll)</option>
            <?php foreach ($categories as $cat): ?>
              <option value="<?= $cat['id'] ?>" <?= $selectedCategory == $cat['id'] ? 'selected' : '' ?>>
                <?= esc($cat['name']) ?> (<?= $cat['courts_count'] ?> Lapangan)
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-lg-3 col-md-4">
          <label class="form-label small fw-bold text-secondary">
            <i class="bi bi-geo me-1 text-success"></i>Pilih Lapangan Tertentu:
          </label>
          <select name="court" class="form-select" onchange="this.form.submit()">
            <option value="">Semua Lapangan</option>
            <?php foreach ($courts as $c): ?>
              <option value="<?= $c['id'] ?>" <?= $selectedCourt == $c['id'] ? 'selected' : '' ?>>
                <?= esc($c['name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-lg-2 col-md-12">
          <a href="<?= base_url('jadwal') ?>" class="btn btn-outline-secondary w-100">
            <i class="bi bi-arrow-clockwise me-1"></i>Reset Filter
          </a>
        </div>
      </form>
    </div>
  </div>

  <!-- Realtime Capacity & Status Counter Bar -->
  <div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
      <div class="p-3 bg-white border rounded-3 d-flex align-items-center gap-3">
        <div class="d-inline-flex p-2.5 rounded-circle bg-success-subtle text-success">
          <i class="bi bi-check2-circle fs-4"></i>
        </div>
        <div>
          <div class="text-secondary small fw-semibold">Slot Tersedia (Kosong)</div>
          <div class="fs-4 fw-bold text-success"><?= $totalAvailable ?> <span class="fs-6 fw-normal text-muted">Jam</span></div>
        </div>
      </div>
    </div>

    <div class="col-md-3 col-6">
      <div class="p-3 bg-white border rounded-3 d-flex align-items-center gap-3">
        <div class="d-inline-flex p-2.5 rounded-circle bg-danger-subtle text-danger">
          <i class="bi bi-x-circle fs-4"></i>
        </div>
        <div>
          <div class="text-secondary small fw-semibold">Slot Terisi (Penuh)</div>
          <div class="fs-4 fw-bold text-danger"><?= $totalBookedCount ?> <span class="fs-6 fw-normal text-muted">Jam</span></div>
        </div>
      </div>
    </div>

    <div class="col-md-3 col-6">
      <div class="p-3 bg-white border rounded-3 d-flex align-items-center gap-3">
        <div class="d-inline-flex p-2.5 rounded-circle bg-warning-subtle text-warning">
          <i class="bi bi-hourglass-split fs-4"></i>
        </div>
        <div>
          <div class="text-secondary small fw-semibold">Menunggu Verifikasi</div>
          <div class="fs-4 fw-bold text-warning"><?= $totalPendingCount ?> <span class="fs-6 fw-normal text-muted">Jam</span></div>
        </div>
      </div>
    </div>

    <div class="col-md-3 col-6">
      <div class="p-3 bg-white border rounded-3 d-flex align-items-center gap-3">
        <div class="d-inline-flex p-2.5 rounded-circle bg-primary-subtle text-primary">
          <i class="bi bi-calendar-event fs-4"></i>
        </div>
        <div>
          <div class="text-secondary small fw-semibold">Tanggal Aktif</div>
          <div class="fw-bold text-dark text-truncate"><?= tanggal_indonesia($selectedDate) ?></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Legend & Mobile Swipe Notice -->
  <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-3">
    <div class="d-flex flex-wrap align-items-center gap-3 small">
      <span class="fw-bold text-secondary">Keterangan:</span>
      <span class="d-inline-flex align-items-center gap-1.5">
        <span class="badge bg-success-subtle text-success border border-success px-2 py-1">Tersedia</span> = Dapat dipesan (Klik slot)
      </span>
      <span class="d-inline-flex align-items-center gap-1.5">
        <span class="badge bg-danger text-white px-2 py-1">Penuh</span> = Sudah dibooking
      </span>
      <span class="d-inline-flex align-items-center gap-1.5">
        <span class="badge bg-warning text-dark px-2 py-1">Proses</span> = Menunggu verifikasi
      </span>
    </div>
    <div class="text-secondary small d-md-none">
      <i class="bi bi-arrows-expand me-1"></i>Geser tabel ke samping untuk melihat jam lainnya &rarr;
    </div>
  </div>

  <!-- Interactive Timetable Matrix Table -->
  <div class="schedule-table-wrapper mb-4">
    <table class="table table-schedule align-middle">
      <thead>
        <tr>
          <th class="sticky-col">Nama Lapangan</th>
          <?php foreach ($timeSlots as $time => $label): ?>
            <th><?= substr($time, 0, 5) ?></th>
          <?php endforeach; ?>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($courts)): ?>
          <tr>
            <td colspan="<?= count($timeSlots) + 1 ?>" class="text-center py-5 text-muted">
              <i class="bi bi-info-circle fs-3 d-block mb-2"></i>
              Tidak ada data lapangan untuk filter yang dipilih.
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($courts as $court): ?>
            <tr>
              <td class="sticky-col">
                <div class="d-flex align-items-center gap-2">
                  <div style="width:36px;height:36px;flex-shrink:0;" class="rounded overflow-hidden bg-dark">
                    <img src="<?= base_url('assets/images/courts/' . esc($court['image'])) ?>" alt="" style="width:100%;height:100%;object-fit:cover;">
                  </div>
                  <div>
                    <a href="<?= base_url('booking/detail/' . $court['id']) ?>" class="fw-bold text-dark text-decoration-none hover-underline">
                      <?= esc($court['name']) ?>
                    </a>
                    <div class="text-muted small">
                      <span class="badge bg-secondary-subtle text-secondary py-0.5 px-1.5"><?= esc($court['category_name']) ?></span>
                      <span><?= rupiah($court['price_per_hour']) ?></span>
                    </div>
                  </div>
                </div>
              </td>

              <?php foreach ($timeSlots as $time => $label): ?>
                <?php 
                  $isOccupied = isset($slotsByCourt[$court['id']][$time]);
                  $slotData   = $isOccupied ? $slotsByCourt[$court['id']][$time] : null;
                ?>
                <td>
                  <?php if (!$isOccupied): ?>
                    <!-- Free slot: Clickable to direct booking -->
                    <a href="<?= base_url('booking/detail/' . $court['id'] . '?date=' . $selectedDate . '&slot=' . $time) ?>" 
                       class="slot-badge slot-available" 
                       title="Pukul <?= substr($time,0,5) ?>: Tersedia. Klik untuk reservasi!">
                      <i class="bi bi-plus-lg small mb-0.5"></i>
                      <span>Kosong</span>
                    </a>
                  <?php elseif ($slotData['booking_status'] === 'pending'): ?>
                    <!-- Pending verification -->
                    <div class="slot-badge slot-pending" title="Pukul <?= substr($time,0,5) ?>: Menunggu konfirmasi pembayaran">
                      <i class="bi bi-hourglass small mb-0.5"></i>
                      <span>Proses</span>
                    </div>
                  <?php else: ?>
                    <!-- Booked / Full -->
                    <div class="slot-badge slot-booked" title="Pukul <?= substr($time,0,5) ?>: Sudah terisi">
                      <i class="bi bi-lock-fill small mb-0.5"></i>
                      <span>Penuh</span>
                    </div>
                  <?php endif; ?>
                </td>
              <?php endforeach; ?>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Help Callout -->
  <div class="card bg-success-subtle border-success-subtle rounded-3 p-3">
    <div class="d-flex align-items-center gap-3">
      <i class="bi bi-lightbulb text-success fs-3"></i>
      <div class="small">
        <strong class="text-success">Tips Reservasi:</strong>
        Untuk memesan beberapa jam sekaligus (misalnya 2 atau 3 jam beruntun), klik salah satu slot kosong di atas untuk masuk ke halaman pemilihan slot jam berkelanjutan.
      </div>
    </div>
  </div>

</div>

<?= $this->endSection() ?>
