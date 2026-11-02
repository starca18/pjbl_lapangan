<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="bg-white border-bottom py-3">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0 small">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('booking') ?>">Pilih Lapangan</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= esc($court['name']) ?></li>
      </ol>
    </nav>
  </div>
</div>

<div class="container py-4">
  <div class="row g-4">
    
    <!-- Left Column: Court Info & Interactive Slot Selection -->
    <div class="col-lg-8">
      
      <!-- Court Banner Card -->
      <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4">
        <div class="row g-0">
          <div class="col-md-5 bg-dark position-relative sport-select-card on border-0 rounded-0 overflow-hidden d-flex align-items-center justify-content-center" id="courtBannerAnimation" style="min-height:220px;">
            <img src="<?= base_url('assets/images/courts/' . esc($court['image'])) ?>" alt="<?= esc($court['name']) ?>" class="w-100 h-100" style="object-fit:cover; min-height:220px;" id="courtBannerFallbackImg">
          </div>
          <div class="col-md-7">
            <div class="card-body p-4">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="badge px-2.5 py-1" style="background-color:var(--sport-primary);color:#fff;"><?= esc($court['category_name']) ?></span>
                <span class="badge bg-secondary-subtle text-secondary font-monospace"><?= esc($court['code']) ?></span>
              </div>
              <h4 class="fw-bold mb-1"><?= esc($court['name']) ?></h4>
              <p class="text-secondary small mb-3"><?= esc($court['description']) ?></p>
              
              <div class="row g-2 small text-secondary">
                <div class="col-6">
                  <i class="bi bi-geo-alt me-1 text-primary"></i>Tipe: <strong><?= esc($court['court_type']) ?></strong>
                </div>
                <div class="col-6">
                  <i class="bi bi-layers me-1 text-success"></i>Lantai: <strong><?= esc($court['floor_type'] ?? '-') ?></strong>
                </div>
                <div class="col-6">
                  <i class="bi bi-cash me-1 text-warning"></i>Tarif: <strong class="text-dark"><?= rupiah($court['price_per_hour']) ?></strong> / jam
                </div>
                <div class="col-6">
                  <i class="bi bi-check2-circle me-1 text-info"></i>Standar: <strong>Kompetisi</strong>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Booking Form -->
      <form action="<?= base_url('booking/process') ?>" method="post" id="bookingForm">
        <?= csrf_field() ?>
        <input type="hidden" name="court_id" value="<?= $court['id'] ?>">

        <!-- Step 1: Select Date -->
        <div class="card border-0 shadow-sm rounded-3 p-4 mb-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">
              <span class="badge bg-success rounded-circle me-2">1</span>Pilih Tanggal Reservasi
            </h5>
            <span class="text-muted small">Format: YYYY-MM-DD</span>
          </div>

          <div class="row g-2 align-items-center">
            <div class="col-sm-6">
              <input type="date" id="bookingDateInput" name="booking_date" class="form-control form-control-lg fs-6" 
                     value="<?= esc($selectedDate) ?>" min="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="col-sm-6 text-secondary small">
              <i class="bi bi-info-circle me-1 text-success"></i>
              Jadwal slot jam di bawah otomatis menyesuaikan tanggal yang Anda pilih.
            </div>
          </div>
        </div>

        <!-- Step 2: Interactive Slot Chooser -->
        <div class="card border-0 shadow-sm rounded-3 p-4 mb-4">
          <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center mb-3 gap-2">
            <h5 class="fw-bold mb-0">
              <span class="badge bg-success rounded-circle me-2">2</span>Pilih Slot Jam Tersedia
            </h5>
            <div class="d-flex gap-3 small">
              <span class="d-inline-flex align-items-center gap-1">
                <span class="badge bg-success-subtle text-success border border-success p-1"></span> Tersedia
              </span>
              <span class="d-inline-flex align-items-center gap-1">
                <span class="badge bg-danger p-1"></span> Sudah Penuh
              </span>
            </div>
          </div>

          <p class="text-secondary small mb-3">
            Klik pada kotak slot jam untuk memilih. Anda dapat memilih lebih dari satu jam beruntun (misal 2 atau 3 jam).
          </p>

          <div class="row g-2" id="slotsContainer">
            <?php foreach ($timeSlots as $time => $label): ?>
              <?php 
                $isOccupied = isset($occupiedMap[$time]);
                $status     = $isOccupied ? $occupiedMap[$time] : 'available';
                $isPreselected = ($preselected === $time && !$isOccupied);
              ?>
              <div class="col-md-6 col-12">
                <label class="slot-select-card w-100 <?= $isOccupied ? 'disabled' : '' ?> <?= $isPreselected ? 'selected' : '' ?>">
                  <div class="d-flex align-items-center gap-2.5">
                    <?php if (!$isOccupied): ?>
                      <input type="checkbox" name="slots[]" value="<?= $time ?>" class="form-check-input slot-checkbox mt-0" <?= $isPreselected ? 'checked' : '' ?>>
                    <?php else: ?>
                      <i class="bi bi-lock-fill text-danger"></i>
                    <?php endif; ?>
                    <div>
                      <div class="fw-bold <?= $isOccupied ? 'text-muted' : 'text-dark' ?>"><?= $label ?> WIB</div>
                      <div class="small <?= $isOccupied ? 'text-danger' : 'text-success' ?>">
                        <?= $isOccupied ? ($status === 'pending' ? 'Sedang Diproses' : 'Sudah Penuh / Dibooking') : 'Tersedia' ?>
                      </div>
                    </div>
                  </div>
                  <div>
                    <?php if (!$isOccupied): ?>
                      <span class="badge bg-success-subtle text-success border border-success-subtle">Pilih</span>
                    <?php else: ?>
                      <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Penuh</span>
                    <?php endif; ?>
                  </div>
                </label>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Step 3: Customer Information -->
        <div class="card border-0 shadow-sm rounded-3 p-4 mb-4">
          <h5 class="fw-bold mb-3">
            <span class="badge bg-success rounded-circle me-2">3</span>Informasi Pemesan & Pembayaran
          </h5>

          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label small fw-bold text-secondary">Nama Lengkap / Nama Tim <span class="text-danger">*</span></label>
              <input type="text" name="customer_name" class="form-control" placeholder="Contoh: Budi Santoso / FC Mandiri" required value="<?= old('customer_name') ?>">
            </div>

            <div class="col-md-6">
              <label class="form-label small fw-bold text-secondary">Nomor WhatsApp Aktif <span class="text-danger">*</span></label>
              <input type="tel" name="customer_phone" class="form-control" placeholder="Contoh: 081234567890" required value="<?= old('customer_phone') ?>">
              <div class="form-text small">Konfirmasi reservasi dan tiket digital dikirimkan ke nomor ini.</div>
            </div>

            <div class="col-md-6">
              <label class="form-label small fw-bold text-secondary">Alamat Email (Opsional)</label>
              <input type="email" name="customer_email" class="form-control" placeholder="Contoh: pemesan@email.com" value="<?= old('customer_email') ?>">
            </div>

            <div class="col-md-6">
              <label class="form-label small fw-bold text-secondary">Metode Pembayaran <span class="text-danger">*</span></label>
              <select name="payment_method" class="form-select" required>
                <option value="Transfer Bank BCA">Transfer Bank BCA</option>
                <option value="Transfer Bank Mandiri">Transfer Bank Mandiri</option>
                <option value="QRIS (Gopay/OVO/ShopeePay/Dana)">QRIS (Instant Payment)</option>
                <option value="Tunai / On-site">Bayar Tunai di Kasir Gelanggang</option>
              </select>
            </div>

            <div class="col-12">
              <label class="form-label small fw-bold text-secondary">Catatan Khusus (Opsional)</label>
              <textarea name="notes" class="form-control" rows="2" placeholder="Catatan tambahan seperti pinjam rompi, sewa bola, atau lainnya..."><?= old('notes') ?></textarea>
            </div>
          </div>
        </div>

        <div class="d-none d-lg-block mb-4">
          <button type="submit" class="btn btn-sport-primary btn-lg w-100 py-3 fw-bold" id="submitBtn">
            <i class="bi bi-check-circle-fill me-2"></i>Konfirmasi Reservasi Sekarang
          </button>
        </div>
      </form>
    </div>

    <!-- Right Column: Sticky Pricing & Reservation Summary -->
    <div class="col-lg-4">
      <div class="card border-0 shadow-sm rounded-3 sticky-top" style="top:90px;">
        <div class="card-header bg-white border-bottom py-3">
          <h5 class="fw-bold mb-0 text-dark">
            <i class="bi bi-receipt text-success me-2"></i>Ringkasan Reservasi
          </h5>
        </div>
        <div class="card-body p-4">
          
          <div class="mb-3 pb-3 border-bottom">
            <div class="text-secondary small">Lapangan Terpilih:</div>
            <div class="fw-bold fs-6 text-dark"><?= esc($court['name']) ?></div>
            <div class="small text-muted"><?= esc($court['category_name']) ?> &bull; <?= esc($court['court_type']) ?></div>
          </div>

          <div class="mb-3 pb-3 border-bottom">
            <div class="text-secondary small">Tanggal Reservasi:</div>
            <div class="fw-bold text-dark" id="summaryDate"><?= tanggal_indonesia($selectedDate) ?></div>
          </div>

          <div class="mb-3 pb-3 border-bottom">
            <div class="d-flex justify-content-between align-items-center mb-1">
              <span class="text-secondary small">Slot Jam Terpilih:</span>
              <span class="badge bg-success-subtle text-success" id="summaryHoursCount">0 Jam</span>
            </div>
            <ul class="list-unstyled mb-0 small text-dark fw-semibold" id="summarySlotsList">
              <li class="text-muted fw-normal fst-italic">Belum ada jam yang dipilih.</li>
            </ul>
          </div>

          <div class="mb-4">
            <div class="d-flex justify-content-between text-secondary small mb-1">
              <span>Tarif per jam:</span>
              <span><?= rupiah($court['price_per_hour']) ?></span>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2 border-top">
              <span class="fw-bold text-dark fs-6">Total Pembayaran:</span>
              <span class="fw-bold fs-4 text-success" id="summaryTotalPrice">Rp 0</span>
            </div>
          </div>

          <div class="d-grid gap-2">
            <button type="button" class="btn btn-sport-primary py-2.5 fw-bold" onclick="document.getElementById('bookingForm').requestSubmit()">
              <i class="bi bi-shield-check me-1.5"></i>Lanjutkan Pemesanan
            </button>
            <a href="<?= base_url('jadwal?court=' . $court['id']) ?>" class="btn btn-light border py-2 text-secondary small">
              <i class="bi bi-arrow-left me-1"></i>Kembali ke Papan Jadwal
            </a>
          </div>

          <div class="mt-3 text-center text-muted small">
            <i class="bi bi-lock me-1"></i>Data transaksi terenkripsi & terjamin aman.
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const pricePerHour = <?= (float) $court['price_per_hour'] ?>;
  const dateInput = document.getElementById('bookingDateInput');
  const summaryDate = document.getElementById('summaryDate');
  const summarySlotsList = document.getElementById('summarySlotsList');
  const summaryHoursCount = document.getElementById('summaryHoursCount');
  const summaryTotalPrice = document.getElementById('summaryTotalPrice');
  const checkboxes = document.querySelectorAll('.slot-checkbox');

  // Change date handler: reload with chosen date
  dateInput.addEventListener('change', function () {
    const newDate = this.value;
    if (newDate) {
      window.location.href = '<?= base_url("booking/detail/" . $court["id"]) ?>?date=' + newDate;
    }
  });

  // Checkbox toggle styling and summary calculation
  function updateSummary() {
    const selectedBoxes = Array.from(checkboxes).filter(cb => cb.checked);
    const count = selectedBoxes.length;

    summaryHoursCount.textContent = count + ' Jam';
    const total = count * pricePerHour;
    summaryTotalPrice.textContent = 'Rp ' + total.toLocaleString('id-ID');

    summarySlotsList.innerHTML = '';
    if (count === 0) {
      summarySlotsList.innerHTML = '<li class="text-muted fw-normal fst-italic">Belum ada jam yang dipilih.</li>';
    } else {
      selectedBoxes.sort((a, b) => a.value.localeCompare(b.value));
      selectedBoxes.forEach(cb => {
        const parentCard = cb.closest('.slot-select-card');
        parentCard.classList.add('selected');
        const timeLabel = parentCard.querySelector('.fw-bold').textContent;
        const li = document.createElement('li');
        li.className = 'd-flex justify-content-between py-1 text-dark';
        li.innerHTML = `<span><i class="bi bi-clock me-1 text-success"></i>${timeLabel}</span><span>1 Jam</span>`;
        summarySlotsList.appendChild(li);
      });
    }

    checkboxes.forEach(cb => {
      const parentCard = cb.closest('.slot-select-card');
      if (!cb.checked) {
        parentCard.classList.remove('selected');
      }
    });
  }

  checkboxes.forEach(cb => {
    cb.addEventListener('change', updateSummary);
  });

  // Initial call in case of preselected slot
  updateSummary();

  // Inject animated sport art into court banner
  if (window.ArenaSportAnimations) {
    const sportData = ArenaSportAnimations.SPORTS.find(s => s.slug === '<?= esc($court['category_slug'] ?? '') ?>');
    if (sportData) {
      const banner = document.getElementById('courtBannerAnimation');
      if (banner) {
        banner.innerHTML = ArenaSportAnimations.generateArt(sportData);
      }
    }
  }
});
</script>
<?= $this->endSection() ?>
