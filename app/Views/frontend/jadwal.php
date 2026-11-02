<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Header & Breadcrumb -->
<div class="bg-white border-bottom py-3 py-md-4">
  <div class="container">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
      <div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-1 small">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Jadwal Lapangan</li>
          </ol>
        </nav>
        <h2 class="fw-bold mb-1 fs-3 fs-md-2">Jadwal Ketersediaan Lapangan</h2>
        <p class="text-secondary small mb-0">
          Pilih tanggal dan jam bermain favorit Anda secara real-time seperti pesan tiket bioskop.
        </p>
      </div>

      <!-- View Switcher (TIX ID Cards vs Table Matrix) -->
      <div class="d-flex align-items-center gap-2">
        <div class="btn-group p-1 bg-light rounded-pill border" role="group" aria-label="Tampilan Jadwal">
          <button type="button" class="btn btn-sm rounded-pill fw-semibold px-3 active" id="btnViewTix" style="font-size:0.82rem;">
            <i class="bi bi-grid-fill me-1"></i>Mode Kartu (TIX ID)
          </button>
          <button type="button" class="btn btn-sm rounded-pill fw-semibold px-3 text-secondary" id="btnViewTable" style="font-size:0.82rem;">
            <i class="bi bi-table me-1"></i>Mode Tabel
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container py-4 pb-5">
  
  <!-- ═══════════════════════════════════════════════════════════════ -->
  <!-- 1. TIX ID DATE RIBBON (Pill Tanggal Horizontal Scrollable)       -->
  <!-- ═══════════════════════════════════════════════════════════════ -->
  <div class="d-flex justify-content-between align-items-center mb-2">
    <span class="text-secondary small fw-bold text-uppercase" style="letter-spacing:0.5px;">
      <i class="bi bi-calendar3 me-1 text-primary"></i>Pilih Tanggal Bermain:
    </span>
    <!-- Custom date picker modal trigger / mini input -->
    <div class="d-flex align-items-center gap-1.5">
      <label for="customDatePicker" class="small text-secondary fw-semibold mb-0" style="cursor:pointer;" title="Pilih tanggal kalender">
        <i class="bi bi-calendar-event me-1"></i>Pilih Tanggal Lain:
      </label>
      <input type="date" id="customDatePicker" class="form-control form-control-sm border-secondary-subtle px-2 py-0.5" 
             style="width:auto; font-size:0.8rem;" 
             value="<?= esc($selectedDate) ?>" min="<?= date('Y-m-d') ?>" 
             onchange="window.location.href='<?= base_url('jadwal?date=') ?>' + this.value + '<?= $selectedCategory ? '&category=' . $selectedCategory : '' ?>'">
    </div>
  </div>

  <div class="tix-date-ribbon-wrapper">
    <div class="tix-date-ribbon">
      <?php foreach ($dateList as $dItem): ?>
        <a href="<?= base_url('jadwal?date=' . $dItem['date'] . ($selectedCategory ? '&category=' . $selectedCategory : '') . ($selectedCourt ? '&court=' . $selectedCourt : '')) ?>" 
           class="tix-date-pill <?= $dItem['is_selected'] ? 'active' : '' ?>">
          <span class="tix-date-num"><?= $dItem['day_num'] ?> <?= $dItem['month'] ?></span>
          <span class="tix-date-label"><?= $dItem['day_name'] ?></span>
        </a>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- ═══════════════════════════════════════════════════════════════ -->
  <!-- 2. QUICK SPORT FILTER PILLS (Cabang Olahraga Filter)            -->
  <!-- ═══════════════════════════════════════════════════════════════ -->
  <div class="tix-sport-pills">
    <a href="<?= base_url('jadwal?date=' . $selectedDate . ($selectedCourt ? '&court=' . $selectedCourt : '')) ?>" 
       class="tix-sport-pill <?= empty($selectedCategory) ? 'active' : '' ?>">
      <i class="bi bi-trophy me-1"></i>Semua Olahraga (<?= count($courts) ?> Lapangan)
    </a>
    <?php foreach ($categories as $cat): ?>
      <a href="<?= base_url('jadwal?date=' . $selectedDate . '&category=' . $cat['id']) ?>" 
         class="tix-sport-pill <?= $selectedCategory == $cat['id'] ? 'active' : '' ?>">
        <?= esc($cat['name']) ?> (<?= $cat['courts_count'] ?>)
      </a>
    <?php endforeach; ?>
  </div>

  <!-- ═══════════════════════════════════════════════════════════════ -->
  <!-- 3. REALTIME STATS & LEGEND                                      -->
  <!-- ═══════════════════════════════════════════════════════════════ -->
  <div class="row g-2 mb-3 align-items-center">
    <div class="col-md-7">
      <div class="d-flex flex-wrap align-items-center gap-2 small">
        <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1.5 rounded-pill">
          <i class="bi bi-check-circle-fill me-1"></i><?= $totalAvailable ?> Jam Tersedia
        </span>
        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2.5 py-1.5 rounded-pill">
          <i class="bi bi-lock-fill me-1"></i><?= $totalBookedCount ?> Jam Penuh
        </span>
        <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2.5 py-1.5 rounded-pill">
          <i class="bi bi-hourglass-split me-1"></i><?= $totalPendingCount ?> Menunggu
        </span>
        <span class="text-secondary small ms-1">
          • <?= tanggal_indonesia($selectedDate) ?>
        </span>
      </div>
    </div>
    <div class="col-md-5 text-md-end">
      <div class="small text-secondary d-flex align-items-center justify-content-md-end gap-3">
        <span class="d-inline-flex align-items-center gap-1">
          <span style="display:inline-block;width:12px;height:12px;background:#fff;border:1.5px solid #cbd5e1;border-radius:3px;"></span>
          Tersedia
        </span>
        <span class="d-inline-flex align-items-center gap-1">
          <span style="display:inline-block;width:12px;height:12px;background:#ea580c;border-radius:3px;"></span>
          Dipilih
        </span>
        <span class="d-inline-flex align-items-center gap-1">
          <span style="display:inline-block;width:12px;height:12px;background:#f1f5f9;border:1px solid #e2e8f0;border-radius:3px;"></span>
          Penuh
        </span>
      </div>
    </div>
  </div>

  <!-- ═══════════════════════════════════════════════════════════════ -->
  <!-- VIEW 1: TIX ID CARDS VIEW (DEFAULT & MOBILE-FIRST)             -->
  <!-- ═══════════════════════════════════════════════════════════════ -->
  <div id="tixScheduleView">
    <?php if (empty($courts)): ?>
      <div class="card border-0 shadow-sm rounded-4 text-center py-5">
        <div class="card-body">
          <i class="bi bi-calendar-x fs-1 text-muted d-block mb-3"></i>
          <h5 class="fw-bold text-dark">Tidak ada lapangan yang cocok</h5>
          <p class="text-secondary small mb-3">Silakan ganti tanggal atau filter cabang olahraga yang dipilih.</p>
          <a href="<?= base_url('jadwal') ?>" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="bi bi-arrow-clockwise me-1"></i>Reset Filter
          </a>
        </div>
      </div>
    <?php else: ?>
      <?php foreach ($courts as $court): ?>
        <?php 
          // Hitung ketersediaan slot untuk lapangan ini
          $courtAvailableCount = 0;
          $courtTotalSlots = count($timeSlots);
          foreach ($timeSlots as $timeKey => $timeLbl) {
            $isOcc = isset($slotsByCourt[$court['id']][$timeKey]);
            $isPast = ($selectedDate === date('Y-m-d') && $timeKey < $currentTime);
            if (!$isOcc && !$isPast) {
              $courtAvailableCount++;
            }
          }
        ?>
        <div class="tix-court-card">
          <!-- Card Header (Venue Info) -->
          <div class="tix-court-header">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">
              <div class="d-flex align-items-center gap-3">
                <div style="width:48px;height:48px;flex-shrink:0;" class="rounded-3 overflow-hidden bg-dark position-relative">
                  <img src="<?= base_url('assets/images/courts/' . esc($court['image'])) ?>" alt="<?= esc($court['name']) ?>" style="width:100%;height:100%;object-fit:cover;">
                </div>
                <div>
                  <div class="d-flex align-items-center gap-2 flex-wrap">
                    <h5 class="fw-bold mb-0 text-dark"><?= esc($court['name']) ?></h5>
                    <span class="badge" style="background:#ffedd5;color:var(--sport-primary);font-size:0.75rem;">
                      <?= esc($court['category_name']) ?>
                    </span>
                    <span class="badge bg-light text-secondary border font-monospace" style="font-size:0.72rem;">
                      <?= esc($court['code']) ?>
                    </span>
                  </div>
                  <div class="text-secondary small d-flex align-items-center gap-2 flex-wrap mt-0.5">
                    <span><i class="bi bi-geo-alt me-0.5 text-primary"></i><?= esc($court['court_type']) ?></span>
                    <span>•</span>
                    <span><i class="bi bi-layers me-0.5 text-success"></i><?= esc($court['floor_type'] ?? 'Standar') ?></span>
                    <span>•</span>
                    <?php if ($courtAvailableCount > 0): ?>
                      <span class="text-success fw-bold">
                        <i class="bi bi-check-circle-fill me-0.5"></i><?= $courtAvailableCount ?> Slot Tersedia
                      </span>
                    <?php else: ?>
                      <span class="text-danger fw-bold">
                        <i class="bi bi-lock-fill me-0.5"></i>Penuh Hari Ini
                      </span>
                    <?php endif; ?>
                  </div>
                </div>
              </div>

              <!-- Price Tag -->
              <div class="text-sm-end mt-1 mt-sm-0">
                <div class="fw-bold fs-5 text-dark" style="color:var(--sport-primary-dark) !important;">
                  <?= rupiah($court['price_per_hour']) ?>
                  <span class="text-secondary fw-normal fs-6">/ jam</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Card Body (Grid of Showtimes like TIX ID) -->
          <div class="tix-court-body">
            <div class="tix-slots-grid">
              <?php foreach ($timeSlots as $time => $label): ?>
                <?php 
                  $isOccupied = isset($slotsByCourt[$court['id']][$time]);
                  $slotData   = $isOccupied ? $slotsByCourt[$court['id']][$time] : null;
                  $isPast     = ($selectedDate === date('Y-m-d') && $time < $currentTime);
                  $displayTime = substr($time, 0, 5);
                ?>
                
                <?php if ($isPast): ?>
                  <!-- Jam Sudah Berlalu -->
                  <div class="tix-slot-chip slot-disabled-past" title="Pukul <?= $displayTime ?> telah lewat">
                    <span class="slot-time"><?= $displayTime ?></span>
                    <span class="slot-label">Lewat</span>
                  </div>
                <?php elseif ($isOccupied): ?>
                  <?php if ($slotData['booking_status'] === 'pending'): ?>
                    <!-- Menunggu Verifikasi -->
                    <div class="tix-slot-chip slot-disabled-pending" title="Pukul <?= $displayTime ?> sedang dalam proses verifikasi">
                      <span class="slot-time"><?= $displayTime ?></span>
                      <span class="slot-label">Proses</span>
                    </div>
                  <?php else: ?>
                    <!-- Sudah Penuh Dibooking -->
                    <div class="tix-slot-chip slot-disabled-booked" title="Pukul <?= $displayTime ?> sudah dibooking">
                      <span class="slot-time"><?= $displayTime ?></span>
                      <span class="slot-label">Penuh</span>
                    </div>
                  <?php endif; ?>
                <?php else: ?>
                  <!-- Slot Tersedia (Clickable TIX ID Style) -->
                  <button type="button" 
                          class="tix-slot-chip slot-free js-tix-slot" 
                          data-court-id="<?= $court['id'] ?>"
                          data-court-name="<?= esc($court['name']) ?>"
                          data-court-category="<?= esc($court['category_name']) ?>"
                          data-court-price="<?= (int) $court['price_per_hour'] ?>"
                          data-date="<?= esc($selectedDate) ?>"
                          data-date-label="<?= esc(tanggal_indonesia($selectedDate)) ?>"
                          data-time="<?= esc($time) ?>"
                          data-display-time="<?= esc($displayTime) ?>"
                          data-slot-label="<?= esc($label) ?>"
                          title="Klik untuk memilih jam <?= $displayTime ?>">
                    <span class="slot-time"><?= $displayTime ?></span>
                    <span class="slot-label">Tersedia</span>
                  </button>
                <?php endif; ?>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

  <!-- ═══════════════════════════════════════════════════════════════ -->
  <!-- VIEW 2: CLASSIC MATRIX TABLE VIEW (OPTIONAL FOR DESKTOP)       -->
  <!-- ═══════════════════════════════════════════════════════════════ -->
  <div id="matrixScheduleView" style="display:none;">
    <div class="text-secondary small mb-2 d-md-none">
      <i class="bi bi-arrows-expand me-1"></i>Geser tabel ke samping untuk melihat jam lainnya &rarr;
    </div>
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
                    $isPast     = ($selectedDate === date('Y-m-d') && $time < $currentTime);
                  ?>
                  <td>
                    <?php if ($isPast): ?>
                      <div class="slot-badge" style="background:#f8fafc;border:1px solid #f1f5f9;color:#cbd5e1;cursor:not-allowed;" title="Lewat">
                        <i class="bi bi-dash-circle small mb-0.5"></i>
                        <span>Lewat</span>
                      </div>
                    <?php elseif (!$isOccupied): ?>
                      <a href="<?= base_url('booking/detail/' . $court['id'] . '?date=' . $selectedDate . '&slot=' . $time) ?>" 
                         class="slot-badge slot-available" 
                         title="Pukul <?= substr($time,0,5) ?>: Tersedia. Klik untuk reservasi!">
                        <i class="bi bi-plus-lg small mb-0.5"></i>
                        <span>Kosong</span>
                      </a>
                    <?php elseif ($slotData['booking_status'] === 'pending'): ?>
                      <div class="slot-badge slot-pending" title="Pukul <?= substr($time,0,5) ?>: Menunggu konfirmasi pembayaran">
                        <i class="bi bi-hourglass small mb-0.5"></i>
                        <span>Proses</span>
                      </div>
                    <?php else: ?>
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
  </div>

  <!-- Help Callout -->
  <div class="card bg-light border rounded-4 p-3 mt-4">
    <div class="d-flex align-items-center gap-3">
      <div class="p-2.5 rounded-circle bg-white text-primary border shadow-sm">
        <i class="bi bi-lightbulb fs-5"></i>
      </div>
      <div class="small">
        <strong class="text-dark">Tips Reservasi Ala TIX ID:</strong>
        Sentuh kotak jam yang bertuliskan <strong>"Tersedia"</strong>. Anda bisa memilih 1 jam atau beberapa jam berurutan pada lapangan yang sama. Setelah memilih, tombol <strong>"PESAN SEKARANG"</strong> di bagian bawah layar akan otomatis muncul!
      </div>
    </div>
  </div>

</div>

<!-- ═══════════════════════════════════════════════════════════════ -->
<!-- 4. TIX ID STICKY BOTTOM BAR (Floating Drawer "BELI TIKET")      -->
<!-- ═══════════════════════════════════════════════════════════════ -->
<div class="tix-bottom-bar" id="tixBottomBar">
  <div class="tix-bottom-bar-inner">
    <div class="tix-bottom-summary">
      <div class="tix-bottom-title" id="tixBottomCourtName">Nama Lapangan</div>
      <div class="tix-bottom-meta">
        <span id="tixBottomDate">Tanggal</span>
        <span>•</span>
        <span class="text-dark fw-bold" id="tixBottomSlots">0 Slot Jam</span>
        <span>•</span>
        <span class="tix-bottom-price" id="tixBottomPrice">Rp 0</span>
      </div>
    </div>
    <div class="d-flex align-items-center gap-2">
      <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-2 d-none d-sm-inline-flex" id="tixBtnReset">
        Batal
      </button>
      <a href="#" class="tix-btn-order" id="tixBtnOrder">
        <i class="bi bi-ticket-perforated-fill"></i>
        <span>PESAN SEKARANG</span>
        <i class="bi bi-arrow-right ms-1"></i>
      </a>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // State variables for slot selection
  let selectedCourtId = null;
  let selectedCourtName = '';
  let selectedPricePerHour = 0;
  let selectedDate = '';
  let selectedDateLabel = '';
  let selectedSlots = []; // array of time strings: ['07:00:00', ...]

  const bottomBar = document.getElementById('tixBottomBar');
  const bottomCourtName = document.getElementById('tixBottomCourtName');
  const bottomDate = document.getElementById('tixBottomDate');
  const bottomSlots = document.getElementById('tixBottomSlots');
  const bottomPrice = document.getElementById('tixBottomPrice');
  const btnOrder = document.getElementById('tixBtnOrder');
  const btnReset = document.getElementById('tixBtnReset');

  const slotButtons = document.querySelectorAll('.js-tix-slot');

  function formatRupiah(num) {
    return 'Rp ' + Number(num).toLocaleString('id-ID');
  }

  function updateBottomBar() {
    if (selectedSlots.length === 0) {
      bottomBar.classList.remove('show');
      return;
    }

    // Sort selected slots chronologically
    selectedSlots.sort();

    const totalHours = selectedSlots.length;
    const totalPrice = totalHours * selectedPricePerHour;

    const startDisplay = selectedSlots[0].substring(0, 5);
    const endSlot = selectedSlots[selectedSlots.length - 1];
    const endHour = parseInt(endSlot.substring(0, 2)) + 1;
    const endDisplay = (endHour < 10 ? '0' + endHour : endHour) + ':00';

    bottomCourtName.textContent = selectedCourtName;
    bottomDate.textContent = selectedDateLabel;
    bottomSlots.textContent = `${startDisplay} - ${endDisplay} (${totalHours} Jam)`;
    bottomPrice.textContent = formatRupiah(totalPrice);

    // Build URL to booking detail with preselected slots
    const targetUrl = '<?= base_url('booking/detail/') ?>' + selectedCourtId 
      + '?date=' + encodeURIComponent(selectedDate) 
      + '&slots=' + encodeURIComponent(selectedSlots.join(','));
    btnOrder.setAttribute('href', targetUrl);

    bottomBar.classList.add('show');
  }

  function resetSelection() {
    slotButtons.forEach(btn => btn.classList.remove('selected'));
    selectedCourtId = null;
    selectedCourtName = '';
    selectedPricePerHour = 0;
    selectedDate = '';
    selectedDateLabel = '';
    selectedSlots = [];
    updateBottomBar();
  }

  if (btnReset) {
    btnReset.addEventListener('click', resetSelection);
  }

  slotButtons.forEach(btn => {
    btn.addEventListener('click', function() {
      const courtId = this.dataset.courtId;
      const courtName = this.dataset.courtName;
      const courtPrice = parseInt(this.dataset.courtPrice, 10);
      const date = this.dataset.date;
      const dateLabel = this.dataset.dateLabel;
      const slotTime = this.dataset.time;

      // If user clicks a slot on a different court, reset previous court's selection
      if (selectedCourtId !== null && selectedCourtId !== courtId) {
        slotButtons.forEach(b => b.classList.remove('selected'));
        selectedSlots = [];
      }

      selectedCourtId = courtId;
      selectedCourtName = courtName;
      selectedPricePerHour = courtPrice;
      selectedDate = date;
      selectedDateLabel = dateLabel;

      // Toggle this slot
      if (this.classList.contains('selected')) {
        this.classList.remove('selected');
        selectedSlots = selectedSlots.filter(t => t !== slotTime);
        if (selectedSlots.length === 0) {
          selectedCourtId = null;
        }
      } else {
        this.classList.add('selected');
        if (!selectedSlots.includes(slotTime)) {
          selectedSlots.push(slotTime);
        }
      }

      updateBottomBar();
    });
  });

  // ═══════════════════════════════════════════════════════════════
  // View Switcher (TIX ID Cards vs Table Matrix)
  // ═══════════════════════════════════════════════════════════════
  const btnViewTix = document.getElementById('btnViewTix');
  const btnViewTable = document.getElementById('btnViewTable');
  const tixView = document.getElementById('tixScheduleView');
  const matrixView = document.getElementById('matrixScheduleView');

  function setViewMode(mode) {
    if (mode === 'table') {
      tixView.style.display = 'none';
      matrixView.style.display = 'block';
      btnViewTable.classList.add('active', 'btn-light');
      btnViewTable.classList.remove('text-secondary');
      btnViewTix.classList.remove('active', 'btn-light');
      btnViewTix.classList.add('text-secondary');
      localStorage.setItem('arena_schedule_view', 'table');
      // Hide TIX bottom bar if switching to table
      bottomBar.classList.remove('show');
    } else {
      matrixView.style.display = 'none';
      tixView.style.display = 'block';
      btnViewTix.classList.add('active', 'btn-light');
      btnViewTix.classList.remove('text-secondary');
      btnViewTable.classList.remove('active', 'btn-light');
      btnViewTable.classList.add('text-secondary');
      localStorage.setItem('arena_schedule_view', 'tix');
      if (selectedSlots.length > 0) {
        bottomBar.classList.add('show');
      }
    }
  }

  btnViewTix.addEventListener('click', () => setViewMode('tix'));
  btnViewTable.addEventListener('click', () => setViewMode('table'));

  // Restore user's view preference (default to TIX)
  const savedView = localStorage.getItem('arena_schedule_view') || 'tix';
  setViewMode(savedView);
});
</script>

<?= $this->endSection() ?>
