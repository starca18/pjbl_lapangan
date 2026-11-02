<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="mb-4">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-1 small">
      <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="<?= base_url('admin/bookings') ?>">Reservasi</a></li>
      <li class="breadcrumb-item active" aria-current="page">Tambah Walk-in</li>
    </ol>
  </nav>
  <h3 class="fw-bold mb-1">Tambah Reservasi Manual (Walk-in / Telepon)</h3>
  <p class="text-secondary small mb-0">Input pemesanan langsung dari tamu yang datang ke lokasi atau menghubungi via kasir.</p>
</div>

<div class="row g-4">
  <div class="col-lg-8">
    <div class="card border-0 shadow-sm rounded-3 p-4 bg-white">
      <form action="<?= base_url('admin/bookings/store') ?>" method="post" id="adminBookingForm">
        <?= csrf_field() ?>

        <div class="row g-3 mb-4">
          <div class="col-md-6">
            <label class="form-label small fw-bold text-secondary">Pilih Lapangan <span class="text-danger">*</span></label>
            <select name="court_id" id="courtSelect" class="form-select" required>
              <option value="">-- Pilih Lapangan --</option>
              <?php foreach ($courts as $c): ?>
                <option value="<?= $c['id'] ?>" data-price="<?= $c['price_per_hour'] ?>" <?= ($preSelectedCourt == $c['id']) ? 'selected' : '' ?>>
                  <?= esc($c['name']) ?> (<?= esc($c['category_name']) ?> - <?= rupiah($c['price_per_hour']) ?>/jam)
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label small fw-bold text-secondary">Tanggal Reservasi <span class="text-danger">*</span></label>
            <input type="date" name="booking_date" id="dateInput" class="form-control" value="<?= esc($preSelectedDate) ?>" min="<?= date('Y-m-d') ?>" required>
          </div>
        </div>

        <!-- Slot Picker -->
        <div class="mb-4">
          <label class="form-label small fw-bold text-secondary d-flex justify-content-between">
            <span>Pilih Jam / Slot Waktu <span class="text-danger">*</span></span>
            <span class="text-muted fw-normal">Pilih satu atau lebih jam</span>
          </label>
          
          <div class="row g-2" id="slotPickerContainer">
            <?php foreach ($timeSlots as $time => $label): ?>
              <?php $isPre = ($preSelectedSlot === $time); ?>
              <div class="col-md-4 col-sm-6">
                <div class="form-check p-2 border rounded-2 bg-light">
                  <input class="form-check-input ms-1 me-2 admin-slot-cb" type="checkbox" name="slots[]" value="<?= $time ?>" id="slot_<?= str_replace(':', '', $time) ?>" <?= $isPre ? 'checked' : '' ?>>
                  <label class="form-check-label small fw-semibold text-dark" for="slot_<?= str_replace(':', '', $time) ?>">
                    <?= $label ?>
                  </label>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <hr class="my-4">

        <!-- Customer Data -->
        <h5 class="fw-bold mb-3 text-dark">Data Pemesan</h5>
        <div class="row g-3 mb-4">
          <div class="col-md-6">
            <label class="form-label small fw-bold text-secondary">Nama Pemesan / Tim <span class="text-danger">*</span></label>
            <input type="text" name="customer_name" class="form-control" placeholder="Nama tamu / club" required value="<?= old('customer_name') ?>">
          </div>

          <div class="col-md-6">
            <label class="form-label small fw-bold text-secondary">Nomor WhatsApp / HP <span class="text-danger">*</span></label>
            <input type="tel" name="customer_phone" class="form-control" placeholder="Contoh: 08123456789" required value="<?= old('customer_phone') ?>">
          </div>

          <div class="col-md-6">
            <label class="form-label small fw-bold text-secondary">Alamat Email (Opsional)</label>
            <input type="email" name="customer_email" class="form-control" placeholder="email@contoh.com" value="<?= old('customer_email') ?>">
          </div>

          <div class="col-md-6">
            <label class="form-label small fw-bold text-secondary">Metode Pembayaran</label>
            <select name="payment_method" class="form-select">
              <option value="Tunai / Kasir">Tunai di Kasir</option>
              <option value="QRIS">QRIS</option>
              <option value="Transfer Bank BCA">Transfer BCA</option>
              <option value="Transfer Bank Mandiri">Transfer Mandiri</option>
              <option value="Debit Card">Kartu Debit</option>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label small fw-bold text-secondary">Status Pembayaran</label>
            <select name="payment_status" class="form-select">
              <option value="paid" selected>Lunas (Paid)</option>
              <option value="dp">Uang Muka (DP)</option>
              <option value="unpaid">Belum Lunas (Unpaid)</option>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label small fw-bold text-secondary">Status Booking</label>
            <select name="status" class="form-select">
              <option value="confirmed" selected>Terkonfirmasi (Confirmed)</option>
              <option value="pending">Menunggu (Pending)</option>
              <option value="completed">Selesai (Completed)</option>
            </select>
          </div>

          <div class="col-12">
            <label class="form-label small fw-bold text-secondary">Catatan Khusus</label>
            <textarea name="notes" class="form-control" rows="2" placeholder="Catatan tambahan..."><?= old('notes') ?></textarea>
          </div>
        </div>

        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-sport-primary px-4 py-2">
            <i class="bi bi-save me-1"></i>Simpan Reservasi
          </button>
          <a href="<?= base_url('admin/bookings') ?>" class="btn btn-light border px-4 py-2">
            Batal
          </a>
        </div>
      </form>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card border-0 shadow-sm rounded-3 p-4 bg-white sticky-top" style="top:80px;">
      <h5 class="fw-bold mb-3 border-bottom pb-2">Kalkulasi Tagihan</h5>
      <div class="d-flex justify-content-between text-secondary small mb-2">
        <span>Tarif per jam:</span>
        <span id="rateLabel">Rp 0</span>
      </div>
      <div class="d-flex justify-content-between text-secondary small mb-2">
        <span>Total jam dipilih:</span>
        <span id="hoursLabel">0 Jam</span>
      </div>
      <div class="d-flex justify-content-between fs-5 fw-bold text-dark pt-3 border-top mb-3">
        <span>Total Biaya:</span>
        <span class="text-success" id="totalLabel">Rp 0</span>
      </div>
      <div class="alert alert-light border small text-muted mb-0">
        <i class="bi bi-info-circle me-1"></i>Sistem akan memvalidasi apakah ada bentrok jadwal dengan reservasi lain secara otomatis.
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const courtSelect = document.getElementById('courtSelect');
  const slotCheckboxes = document.querySelectorAll('.admin-slot-cb');
  const rateLabel = document.getElementById('rateLabel');
  const hoursLabel = document.getElementById('hoursLabel');
  const totalLabel = document.getElementById('totalLabel');

  function calculate() {
    const selectedOption = courtSelect.options[courtSelect.selectedIndex];
    const price = selectedOption ? parseFloat(selectedOption.getAttribute('data-price') || 0) : 0;
    
    let checkedCount = 0;
    slotCheckboxes.forEach(cb => {
      if (cb.checked) checkedCount++;
    });

    rateLabel.textContent = 'Rp ' + price.toLocaleString('id-ID');
    hoursLabel.textContent = checkedCount + ' Jam';
    const total = checkedCount * price;
    totalLabel.textContent = 'Rp ' + total.toLocaleString('id-ID');
  }

  courtSelect.addEventListener('change', calculate);
  slotCheckboxes.forEach(cb => cb.addEventListener('change', calculate));

  calculate();
});
</script>
<?= $this->endSection() ?>
