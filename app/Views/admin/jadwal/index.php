<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
  <div>
    <h3 class="fw-bold mb-1">Master Jadwal Lapangan</h3>
    <p class="text-secondary small mb-0">
      Monitoring seluruh jam operasional lapangan secara visual. Klik slot kosong untuk booking walk-in, klik slot terisi untuk melihat detail.
    </p>
  </div>
  <div class="d-flex gap-2">
    <a href="<?= base_url('admin/bookings/create') ?>" class="btn btn-sport-primary btn-sm">
      <i class="bi bi-plus-circle me-1"></i>Tambah Reservasi Manual
    </a>
  </div>
</div>

<!-- Date and Category Filter -->
<div class="card border-0 shadow-sm rounded-3 p-3 bg-white mb-4">
  <form action="<?= base_url('admin/jadwal') ?>" method="get" class="row g-3 align-items-end">
    <div class="col-md-4 col-sm-6">
      <label class="form-label small fw-bold text-secondary">
        <i class="bi bi-calendar3 me-1" style="color:var(--sport-primary);"></i>Pilih Tanggal:
      </label>
      <input type="date" name="date" class="form-control" value="<?= esc($selectedDate) ?>" onchange="this.form.submit()">
    </div>

    <div class="col-md-4 col-sm-6">
      <label class="form-label small fw-bold text-secondary">
        <i class="bi bi-filter me-1" style="color:var(--sport-primary);"></i>Filter Cabang Olahraga:
      </label>
      <select name="category" class="form-select" onchange="this.form.submit()">
        <option value="">Semua Cabang Olahraga</option>
        <?php foreach ($categories as $cat): ?>
          <option value="<?= $cat['id'] ?>" <?= $selectedCategory == $cat['id'] ? 'selected' : '' ?>>
            <?= esc($cat['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-4 col-sm-12 d-flex gap-2">
      <?php 
        $today = date('Y-m-d');
        $tomorrow = date('Y-m-d', strtotime('+1 day'));
      ?>
      <a href="<?= base_url('admin/jadwal?date=' . $today) ?>" class="btn btn-outline-secondary flex-grow-1 <?= $selectedDate === $today ? 'active' : '' ?>">
        Hari Ini
      </a>
      <a href="<?= base_url('admin/jadwal?date=' . $tomorrow) ?>" class="btn btn-outline-secondary flex-grow-1 <?= $selectedDate === $tomorrow ? 'active' : '' ?>">
        Besok
      </a>
    </div>
  </form>
</div>

<!-- Schedule Matrix Table -->
<div class="schedule-table-wrapper mb-4">
  <table class="table table-schedule align-middle">
    <thead>
      <tr>
        <th class="sticky-col">Lapangan</th>
        <?php foreach ($timeSlots as $time => $label): ?>
          <th><?= substr($time, 0, 5) ?></th>
        <?php endforeach; ?>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($courts)): ?>
        <tr>
          <td colspan="<?= count($timeSlots) + 1 ?>" class="text-center py-5 text-muted">
            Tidak ada lapangan yang ditemukan.
          </td>
        </tr>
      <?php else: ?>
        <?php foreach ($courts as $court): ?>
          <tr>
            <td class="sticky-col">
              <div class="d-flex align-items-center gap-2">
                <div style="width:32px;height:32px;flex-shrink:0;" class="rounded overflow-hidden bg-dark">
                  <img src="<?= base_url('assets/images/courts/' . esc($court['image'])) ?>" alt="" style="width:100%;height:100%;object-fit:cover;">
                </div>
                <div>
                  <div class="fw-bold text-dark text-truncate" style="max-width:180px;"><?= esc($court['name']) ?></div>
                  <div class="text-muted small"><?= esc($court['category_name']) ?> &bull; <?= rupiah($court['price_per_hour']) ?></div>
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
                  <!-- Free slot: click to add walk-in booking -->
                  <a href="<?= base_url('admin/bookings/create?court_id=' . $court['id'] . '&date=' . $selectedDate . '&slot=' . $time) ?>" 
                     class="slot-badge slot-available" 
                     title="Slot Kosong. Klik untuk input booking manual">
                    <i class="bi bi-plus-lg small mb-0.5"></i>
                    <span>Kosong</span>
                  </a>
                <?php else: ?>
                  <!-- Occupied slot: click to view booking detail -->
                  <a href="<?= base_url('admin/bookings/detail/' . $slotData['booking_id']) ?>" 
                     class="slot-badge <?= $slotData['booking_status'] === 'pending' ? 'slot-pending' : 'slot-booked' ?>" 
                     title="Pemesan: <?= esc($slotData['customer_name']) ?> (<?= esc($slotData['booking_code']) ?>). Klik untuk lihat detail">
                    <span class="text-truncate" style="max-width:70px;"><?= esc($slotData['customer_name']) ?></span>
                    <span style="font-size:0.65rem; opacity:0.85;"><?= $slotData['booking_status'] === 'pending' ? 'Pending' : 'Penuh' ?></span>
                  </a>
                <?php endif; ?>
              </td>
            <?php endforeach; ?>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<div class="d-flex flex-wrap gap-4 align-items-center small text-secondary">
  <span><span class="badge bg-success-subtle text-success border border-success me-1">Kosong</span> Klik untuk membuat booking walk-in</span>
  <span><span class="badge bg-danger text-white me-1">Nama Pemesan</span> Klik untuk melihat detail & status pembayaran</span>
  <span><span class="badge bg-warning text-dark me-1">Pending</span> Menunggu verifikasi pembayaran</span>
</div>

<?= $this->endSection() ?>
