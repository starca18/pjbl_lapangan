<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
/* Guaranteed Schedule Layout Styles (Inlined for instant render without cache delays) */
.tix-date-ribbon-wrapper {
  position: relative;
  margin-bottom: 1.25rem;
}
.tix-date-ribbon {
  display: flex !important;
  gap: 0.5rem !important;
  overflow-x: auto !important;
  -webkit-overflow-scrolling: touch;
  padding: 0.25rem 0.15rem 0.65rem 0.15rem !important;
  scrollbar-width: none;
}
.tix-date-ribbon::-webkit-scrollbar { display: none; }
.tix-date-pill {
  display: flex !important;
  flex-direction: column !important;
  align-items: center !important;
  justify-content: center !important;
  min-width: 82px !important;
  padding: 0.6rem 0.85rem !important;
  border-radius: 12px !important;
  border: 1.5px solid #fed7aa !important;
  background-color: #ffffff !important;
  text-decoration: none !important;
  color: #334155 !important;
  transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
  cursor: pointer;
  flex-shrink: 0 !important;
  user-select: none;
}
.tix-date-pill:hover {
  border-color: #f97316 !important;
  color: #c2410c !important;
  background-color: #fff7ed !important;
  transform: translateY(-2px);
}
.tix-date-pill.active {
  background: linear-gradient(135deg, #c2410c 0%, #ea580c 50%, #f97316 100%) !important;
  border-color: #c2410c !important;
  color: #ffffff !important;
  box-shadow: 0 4px 14px rgba(234, 88, 12, 0.35) !important;
  transform: translateY(-2px);
}
.tix-date-pill .tix-date-num {
  font-size: 0.95rem;
  font-weight: 800;
  line-height: 1.15;
}
.tix-date-pill .tix-date-label {
  font-size: 0.68rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  margin-top: 2px;
  opacity: 0.8;
}
.tix-date-pill.active .tix-date-label {
  color: #fff7ed !important;
  opacity: 1 !important;
  font-weight: 800 !important;
}
.tix-sport-pills {
  display: flex !important;
  gap: 0.45rem !important;
  overflow-x: auto !important;
  -webkit-overflow-scrolling: touch;
  padding-bottom: 0.5rem !important;
  scrollbar-width: none;
  margin-bottom: 1.25rem !important;
}
.tix-sport-pills::-webkit-scrollbar { display: none; }
.tix-sport-pill {
  display: inline-flex !important;
  align-items: center !important;
  gap: 0.45rem !important;
  padding: 0.45rem 1rem !important;
  border-radius: 9999px !important;
  font-size: 0.82rem !important;
  font-weight: 600 !important;
  text-decoration: none !important;
  border: 1.5px solid #fed7aa !important;
  background-color: #ffffff !important;
  color: #475569 !important;
  white-space: nowrap !important;
  flex-shrink: 0 !important;
  transition: all 0.15s ease;
}
.tix-sport-pill i {
  font-size: 0.95rem;
}
.tix-sport-pill:hover {
  border-color: #f97316 !important;
  color: #c2410c !important;
  background-color: #fff7ed !important;
}
.tix-sport-pill.active {
  background: linear-gradient(135deg, #c2410c 0%, #ea580c 50%, #f97316 100%) !important;
  color: #ffffff !important;
  border-color: #c2410c !important;
  box-shadow: 0 3px 10px rgba(234, 88, 12, 0.35) !important;
}
.tix-court-card {
  background-color: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 16px;
  margin-bottom: 1.25rem;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
  overflow: hidden;
}
.tix-court-header {
  padding: 0.95rem 1.15rem;
  border-bottom: 1px solid #f1f5f9;
}
.tix-court-icon-badge {
  width: 44px;
  height: 44px;
  min-width: 44px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.25rem;
  margin-right: 14px;
  flex-shrink: 0;
  transition: transform 0.2s ease;
}
.tix-court-card:hover .tix-court-icon-badge {
  transform: scale(1.05);
}
.cat-futsal {
  background: #fff7ed;
  color: #ea580c;
  border: 1.5px solid #fed7aa;
}
.cat-mini-soccer {
  background: #f0fdf4;
  color: #16a34a;
  border: 1.5px solid #bbf7d0;
}
.cat-badminton {
  background: #f0fdfa;
  color: #0d9488;
  border: 1.5px solid #99f6e4;
}
.cat-voli {
  background: #eff6ff;
  color: #2563eb;
  border: 1.5px solid #bfdbfe;
}
.cat-tenis {
  background: #fefce8;
  color: #ca8a04;
  border: 1.5px solid #fef08a;
}
.cat-padel {
  background: #faf5ff;
  color: #7c3aed;
  border: 1.5px solid #e9d5ff;
}
.cat-default {
  background: #f8fafc;
  color: #64748b;
  border: 1.5px solid #e2e8f0;
}
.tix-court-body {
  padding: 0.85rem 1.15rem 1.15rem 1.15rem;
}

/* Showtime / Slots Grid (Responsive 2-4 cols) */
.tix-slots-grid {
  display: grid !important;
  grid-template-columns: repeat(2, 1fr) !important;
  gap: 0.65rem !important;
}
@media (min-width: 480px) {
  .tix-slots-grid {
    grid-template-columns: repeat(3, 1fr) !important;
    gap: 0.75rem !important;
  }
}
@media (min-width: 768px) {
  .tix-slots-grid {
    grid-template-columns: repeat(4, 1fr) !important;
    gap: 0.85rem !important;
  }
}
@media (min-width: 1200px) {
  .tix-slots-grid {
    grid-template-columns: repeat(4, 1fr) !important;
    gap: 1rem !important;
  }
}

/* Time Slot Chip (3-line Card Structure: Duration, Time Range, Price/Status) */
.tix-slot-chip {
  display: flex !important;
  flex-direction: column !important;
  align-items: center !important;
  justify-content: center !important;
  min-height: 82px !important;
  padding: 0.75rem 0.45rem !important;
  border-radius: 12px !important;
  border: 1.5px solid #fed7aa !important;
  background-color: #ffffff !important;
  color: #0f172a !important;
  text-decoration: none !important;
  cursor: pointer;
  user-select: none;
  width: 100% !important;
  transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
  box-shadow: 0 1px 4px rgba(0, 0, 0, 0.03);
  text-align: center;
}
.tix-slot-chip .slot-duration {
  font-size: 0.72rem !important;
  font-weight: 600 !important;
  color: #64748b !important;
  letter-spacing: 0.2px;
  line-height: 1;
  margin-bottom: 4px;
}
.tix-slot-chip .slot-time-range {
  font-size: 0.92rem !important;
  font-weight: 800 !important;
  line-height: 1.15;
  letter-spacing: -0.2px;
  color: #0f172a !important;
  white-space: nowrap;
}
.tix-slot-chip .slot-price-tag {
  font-size: 0.82rem !important;
  font-weight: 700 !important;
  color: #c2410c !important;
  margin-top: 5px;
  line-height: 1;
}
.tix-slot-chip .slot-status-tag {
  font-size: 0.75rem !important;
  font-weight: 700 !important;
  margin-top: 5px;
  line-height: 1;
}

/* Hover Available */
.tix-slot-chip.slot-free:hover {
  border-color: #ea580c !important;
  background-color: #fff7ed !important;
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(234, 88, 12, 0.2) !important;
}
.tix-slot-chip.slot-free:hover .slot-time-range {
  color: #c2410c !important;
}

/* Selected State */
.tix-slot-chip.selected {
  background: linear-gradient(135deg, #c2410c 0%, #ea580c 50%, #f97316 100%) !important;
  border-color: #c2410c !important;
  color: #ffffff !important;
  box-shadow: 0 6px 20px rgba(234, 88, 12, 0.45) !important;
  transform: translateY(-2px) scale(1.02);
}
.tix-slot-chip.selected .slot-duration { color: #ffedd5 !important; }
.tix-slot-chip.selected .slot-time-range { color: #ffffff !important; }
.tix-slot-chip.selected .slot-price-tag { color: #ffffff !important; font-weight: 800 !important; }

/* Booked / Full State */
.tix-slot-chip.slot-disabled-booked {
  background-color: #f8fafc !important;
  border-color: #e2e8f0 !important;
  color: #94a3b8 !important;
  cursor: not-allowed;
  opacity: 0.75;
}
.tix-slot-chip.slot-disabled-booked .slot-duration { color: #94a3b8 !important; }
.tix-slot-chip.slot-disabled-booked .slot-time-range { color: #94a3b8 !important; }
.tix-slot-chip.slot-disabled-booked .slot-status-tag { color: #94a3b8 !important; font-weight: 600 !important; }

/* Pending State */
.tix-slot-chip.slot-disabled-pending {
  background-color: #fffbeb !important;
  border-color: #fde68a !important;
  color: #b45309 !important;
  cursor: not-allowed;
  opacity: 0.9;
}
.tix-slot-chip.slot-disabled-pending .slot-duration { color: #b45309 !important; }
.tix-slot-chip.slot-disabled-pending .slot-time-range { color: #b45309 !important; }
.tix-slot-chip.slot-disabled-pending .slot-status-tag { color: #d97706 !important; }

/* Past Hour State */
.tix-slot-chip.slot-disabled-past {
  background-color: #f8fafc !important;
  border-color: #f1f5f9 !important;
  color: #cbd5e1 !important;
  cursor: not-allowed;
  opacity: 0.55;
}
.tix-slot-chip.slot-disabled-past .slot-duration { color: #cbd5e1 !important; }
.tix-slot-chip.slot-disabled-past .slot-time-range { color: #cbd5e1 !important; }
.tix-slot-chip.slot-disabled-past .slot-status-tag { color: #94a3b8 !important; }

/* Sticky Bottom Action Drawer ("RESERVASI") */
.tix-bottom-bar {
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  z-index: 1040;
  background-color: #ffffff;
  border-top: 1px solid #e2e8f0;
  box-shadow: 0 -6px 25px rgba(0, 0, 0, 0.12);
  padding: 0.85rem 1rem;
  transform: translateY(115%);
  transition: transform 0.28s cubic-bezier(0.16, 1, 0.3, 1);
}
.tix-bottom-bar.show { transform: translateY(0); }
.tix-bottom-bar-inner {
  max-width: 1140px;
  margin: 0 auto;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1rem;
}
.tix-bottom-title {
  font-weight: 700;
  font-size: 0.92rem;
  color: #0f172a;
}
.tix-bottom-meta {
  font-size: 0.8rem;
  color: #64748b;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}
.tix-bottom-price {
  font-weight: 800;
  color: #c2410c;
  font-size: 1.05rem;
}
.tix-btn-order {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  background: linear-gradient(135deg, #c2410c 0%, #ea580c 50%, #f97316 100%);
  color: #ffffff !important;
  border: none;
  font-weight: 700;
  font-size: 0.92rem;
  padding: 0.75rem 1.5rem;
  border-radius: 12px;
  text-decoration: none !important;
  box-shadow: 0 4px 12px rgba(234, 88, 12, 0.35);
}
@media (max-width: 576px) {
  .tix-bottom-bar { padding: 0.75rem 0.85rem; }
  .tix-btn-order { padding: 0.65rem 1.15rem; font-size: 0.85rem; }
}
</style>

<!-- Header (Clean & Compact) -->
<div class="bg-white border-bottom py-3">
  <div class="container d-flex align-items-center justify-content-between gap-3">
    <div class="d-flex align-items-center" style="gap:10px;">
      <span class="d-inline-flex align-items-center justify-content-center text-white rounded-3" style="width:34px;height:34px;background:linear-gradient(135deg, #ea580c, #f97316);box-shadow:0 2px 6px rgba(234,88,12,0.25);">
        <i class="bi bi-calendar3" style="font-size:0.95rem;"></i>
      </span>
      <h1 class="h5 fw-bold mb-0 text-dark">Jadwal Lapangan</h1>
    </div>
    <div class="d-flex align-items-center">
      <input type="date" id="customDatePicker" class="form-control form-control-sm px-2.5 py-1.5" 
             style="width:auto; font-size:0.85rem; border:1.5px solid #fed7aa; background:#fff7ed; color:#c2410c; font-weight:600; border-radius:10px;" 
             value="<?= esc($selectedDate) ?>" min="<?= date('Y-m-d') ?>" 
             title="Pilih tanggal bermain"
             onchange="window.location.href='<?= base_url('jadwal?date=') ?>' + this.value + '<?= $selectedCategory ? '&category=' . $selectedCategory : '' ?>'">
    </div>
  </div>
</div>

<div class="container py-3 pb-5">
  
  <!-- 1. DATE RIBBON -->
  <div class="tix-date-ribbon-wrapper mb-2">
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

  <!-- 2. QUICK SPORT FILTER PILLS -->
  <div class="tix-sport-pills mb-3">
    <a href="<?= base_url('jadwal?date=' . $selectedDate . ($selectedCourt ? '&court=' . $selectedCourt : '')) ?>" 
       class="tix-sport-pill <?= empty($selectedCategory) ? 'active' : '' ?>">
      <i class="bi bi-trophy"></i>
      <span>Semua (<?= $totalAllCourts ?? count($courts) ?>)</span>
    </a>
    <?php foreach ($categories as $cat): ?>
      <a href="<?= base_url('jadwal?date=' . $selectedDate . '&category=' . $cat['id']) ?>" 
         class="tix-sport-pill <?= $selectedCategory == $cat['id'] ? 'active' : '' ?>">
        <i class="bi <?= esc($cat['icon']) ?>"></i>
        <span><?= esc($cat['name']) ?> (<?= $cat['courts_count'] ?>)</span>
      </a>
    <?php endforeach; ?>
  </div>

  <!-- CARDS VIEW (CLEAN & MOBILE-FIRST) -->
  <div id="scheduleCardsView">
    <?php if (empty($courts)): ?>
      <div class="card border-0 shadow-sm rounded-4 text-center py-5">
        <div class="card-body">
          <i class="bi bi-calendar-x fs-1 text-muted d-block mb-3"></i>
          <h5 class="fw-bold text-dark">Tidak ada lapangan yang cocok</h5>
          <p class="text-secondary small mb-3">Pilih tanggal atau cabang olahraga lain.</p>
          <a href="<?= base_url('jadwal') ?>" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="bi bi-arrow-clockwise me-1"></i>Reset Filter
          </a>
        </div>
      </div>
    <?php else: ?>
      <?php foreach ($courts as $court): ?>
        <div class="tix-court-card">
          <!-- Card Header (Venue Info) -->
          <div class="tix-court-header">
            <div class="d-flex justify-content-between align-items-center gap-2">
              <div class="d-flex align-items-center">
                <div class="tix-court-icon-badge cat-<?= esc($court['category_slug'] ?? 'default') ?>">
                  <i class="bi <?= esc($court['category_icon'] ?? 'bi-trophy') ?>"></i>
                </div>
                <div>
                  <h5 class="fw-bold mb-1 text-dark fs-6" style="line-height:1.2;"><?= esc($court['name']) ?></h5>
                  <div class="d-flex align-items-center gap-1.5 flex-wrap">
                    <span class="badge" style="background:#ffedd5;color:var(--sport-primary);font-size:0.72rem;font-weight:600;">
                      <?= esc($court['category_name']) ?>
                    </span>
                    <span class="badge bg-light text-secondary border" style="font-size:0.7rem;">
                      <?= esc($court['court_type']) ?>
                    </span>
                  </div>
                </div>
              </div>

              <!-- Price Tag -->
              <div class="text-end" style="flex-shrink:0;">
                <div class="fw-bold fs-6 text-dark" style="color:var(--sport-primary-dark) !important; white-space:nowrap;">
                  <?= rupiah($court['price_per_hour']) ?><span class="text-secondary fw-normal small">/jam</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Card Body (Grid of Showtimes - 3-Line Card Structure) -->
          <div class="tix-court-body">
            <div class="tix-slots-grid">
              <?php foreach ($timeSlots as $time => $label): ?>
                <?php 
                  $isOccupied = isset($slotsByCourt[$court['id']][$time]);
                  $slotData   = $isOccupied ? $slotsByCourt[$court['id']][$time] : null;
                  $isPast     = ($selectedDate === date('Y-m-d') && $time < $currentTime);
                  
                  // Compute 1-hour range e.g. 07:00 - 08:00
                  $startDisplay = substr($time, 0, 5);
                  $startHour = (int) substr($time, 0, 2);
                  $endHour = $startHour + 1;
                  $endDisplay = ($endHour < 10 ? '0' . $endHour : $endHour) . ':00';
                  $timeRange = $startDisplay . ' - ' . $endDisplay;
                ?>
                
                <?php if ($isPast): ?>
                  <!-- Jam Sudah Berlalu -->
                  <div class="tix-slot-chip slot-disabled-past" title="Pukul <?= $timeRange ?> telah lewat">
                    <span class="slot-duration">60 Menit</span>
                    <span class="slot-time-range"><?= $timeRange ?></span>
                    <span class="slot-status-tag">Lewat</span>
                  </div>
                <?php elseif ($isOccupied): ?>
                  <?php if ($slotData['booking_status'] === 'pending'): ?>
                    <!-- Menunggu Verifikasi -->
                    <div class="tix-slot-chip slot-disabled-pending" title="Pukul <?= $timeRange ?> sedang dalam proses verifikasi">
                      <span class="slot-duration">60 Menit</span>
                      <span class="slot-time-range"><?= $timeRange ?></span>
                      <span class="slot-status-tag">Proses</span>
                    </div>
                  <?php else: ?>
                    <!-- Sudah Penuh / Booked -->
                    <div class="tix-slot-chip slot-disabled-booked" title="Pukul <?= $timeRange ?> sudah dibooking">
                      <span class="slot-duration">60 Menit</span>
                      <span class="slot-time-range"><?= $timeRange ?></span>
                      <span class="slot-status-tag">Booked</span>
                    </div>
                  <?php endif; ?>
                <?php else: ?>
                  <!-- Slot Tersedia -->
                  <button type="button" 
                          class="tix-slot-chip slot-free js-tix-slot" 
                          data-court-id="<?= $court['id'] ?>"
                          data-court-name="<?= esc($court['name']) ?>"
                          data-court-category="<?= esc($court['category_name']) ?>"
                          data-court-price="<?= (int) $court['price_per_hour'] ?>"
                          data-date="<?= esc($selectedDate) ?>"
                          data-date-label="<?= esc(tanggal_indonesia($selectedDate)) ?>"
                          data-time="<?= esc($time) ?>"
                          data-display-time="<?= esc($startDisplay) ?>"
                          data-time-range="<?= esc($timeRange) ?>"
                          data-slot-label="<?= esc($label) ?>"
                          title="Pilih jam <?= $timeRange ?> - <?= rupiah($court['price_per_hour']) ?>">
                    <span class="slot-duration">60 Menit</span>
                    <span class="slot-time-range"><?= $timeRange ?></span>
                    <span class="slot-price-tag"><?= rupiah($court['price_per_hour']) ?></span>
                  </button>
                <?php endif; ?>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

</div>

<!-- ═══════════════════════════════════════════════════════════════ -->
<!-- STICKY BOTTOM BAR (Floating Drawer "RESERVASI")                -->
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
        <i class="bi bi-calendar-check-fill"></i>
        <span>RESERVASI</span>
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
});
</script>

<?= $this->endSection() ?>
