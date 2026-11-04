<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      
      <!-- Success Top Banner -->
      <div class="text-center mb-4">
        <div class="d-inline-flex align-items-center justify-content-center bg-success text-white rounded-circle p-3 mb-3 shadow">
          <i class="bi bi-check-lg display-5"></i>
        </div>
        <h2 class="fw-bold mb-1">Reservasi Anda Berhasil Dibuat!</h2>
        <p class="text-secondary">
          Slot lapangan sudah diamankan. Tunjukkan kode booking ini saat tiba di lokasi.
        </p>
      </div>

      <!-- Ticket Card -->
      <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-4" id="printableTicket">
        <div class="bg-success text-white p-4 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">
          <div>
            <span class="badge bg-white text-success fw-bold px-2.5 py-1 mb-1">TIKET RESERVASI ARENASPORT</span>
            <div class="h5 mb-0 fw-bold">ArenaSport Center Gelanggang</div>
          </div>
          <div class="text-sm-end">
            <div class="small opacity-75">Kode Booking:</div>
            <div class="font-monospace fs-4 fw-bold tracking-wider text-warning"><?= esc($booking['booking_code']) ?></div>
          </div>
        </div>

        <div class="card-body p-4 p-md-5 bg-white">
          <div class="row g-4">
            
            <div class="col-md-6 border-end-md">
              <h6 class="text-secondary small fw-bold text-uppercase mb-3" style="letter-spacing:1px;">Rincian Lapangan & Jadwal</h6>
              
              <div class="mb-3">
                <div class="text-muted small">Nama Lapangan:</div>
                <div class="fw-bold fs-5 text-dark"><?= esc($booking['court_name']) ?></div>
                <div class="small text-secondary"><?= esc($booking['category_name']) ?> &bull; <?= esc($booking['court_type']) ?></div>
              </div>

              <div class="mb-3">
                <div class="text-muted small">Tanggal Main:</div>
                <div class="fw-bold text-dark fs-6">
                  <i class="bi bi-calendar-check text-success me-1"></i><?= tanggal_indonesia($booking['booking_date']) ?>
                </div>
              </div>

              <div class="mb-3">
                <div class="text-muted small">Jam Sewa:</div>
                <div class="fw-bold text-dark fs-6">
                  <i class="bi bi-clock text-primary me-1"></i><?= substr($booking['start_time'], 0, 5) ?> - <?= substr($booking['end_time'], 0, 5) ?> WIB
                  <span class="badge bg-secondary-subtle text-secondary ms-1"><?= $booking['total_hours'] ?> Jam</span>
                </div>
              </div>

              <div>
                <div class="text-muted small">Lantai Lapangan:</div>
                <div class="text-dark small fw-semibold"><?= esc($booking['floor_type'] ?? 'Standar') ?></div>
              </div>
            </div>

            <div class="col-md-6">
              <h6 class="text-secondary small fw-bold text-uppercase mb-3" style="letter-spacing:1px;">Rincian Pemesan & Tagihan</h6>
              
              <div class="mb-3">
                <div class="text-muted small">Nama Pemesan / Tim:</div>
                <div class="fw-bold text-dark fs-6"><?= esc($booking['customer_name']) ?></div>
              </div>

              <div class="mb-3">
                <div class="text-muted small">Nomor WhatsApp:</div>
                <div class="text-dark"><?= esc($booking['customer_phone']) ?></div>
              </div>

              <div class="mb-3">
                <div class="text-muted small">Metode Pembayaran:</div>
                <div class="text-dark fw-semibold"><?= esc($booking['payment_method']) ?></div>
                <div class="mt-1"><?= badge_payment($booking['payment_status']) ?></div>
              </div>

              <div class="pt-2 border-top">
                <div class="text-muted small">Total Biaya Sewa:</div>
                <div class="fw-bold fs-3 text-success"><?= rupiah($booking['total_price']) ?></div>
              </div>
            </div>

          </div>

          <!-- Notes -->
          <?php if (!empty($booking['notes'])): ?>
            <div class="mt-4 p-3 bg-light rounded-3 small">
              <strong class="text-secondary">Catatan Pemesan:</strong> <?= esc($booking['notes']) ?>
            </div>
          <?php endif; ?>

          <!-- Important Rules -->
          <div class="mt-4 pt-4 border-top text-secondary small">
            <h6 class="fw-bold text-dark mb-2"><i class="bi bi-info-circle text-primary me-1"></i>Ketentuan & Check-in:</h6>
            <ul class="mb-0 ps-3 d-flex flex-column gap-1">
              <li>Harap hadir di lokasi minimal 15 menit sebelum jam mulai sewa.</li>
              <li>Wajib mengenakan sepatu olahraga sesuai jenis lantai lapangan (non-marking untuk vinyl/parquet).</li>
              <li>Tunjukkan kode booking <strong><?= esc($booking['booking_code']) ?></strong> kepada staf kasir.</li>
            </ul>
          </div>
        </div>

        <div class="card-footer bg-light p-3 text-center border-top small text-muted">
          Simpan bukti reservasi ini sebagai tanda masuk lapangan.
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="d-flex flex-wrap gap-2 justify-content-center">
        <button type="button" class="btn btn-outline-dark px-4 py-2" onclick="window.print()">
          <i class="bi bi-printer me-1.5"></i>Cetak / Simpan PDF
        </button>

        <?php 
          $waText = urlencode("Halo Admin ArenaSport, saya telah melakukan reservasi lapangan:\n\nKode Booking: " . $booking['booking_code'] . "\nLapangan: " . $booking['court_name'] . "\nTanggal: " . tanggal_indonesia($booking['booking_date']) . "\nJam: " . substr($booking['start_time'],0,5) . " - " . substr($booking['end_time'],0,5) . " WIB\nTotal: " . rupiah($booking['total_price']) . "\n\nMohon konfirmasinya. Terima kasih!");
        ?>
        <a href="https://wa.me/6281234567890?text=<?= $waText ?>" target="_blank" class="btn btn-success px-4 py-2">
          <i class="bi bi-whatsapp me-1.5"></i>Konfirmasi via WhatsApp
        </a>

        <a href="<?= base_url('jadwal') ?>" class="btn btn-sport-primary px-4 py-2">
          <i class="bi bi-calendar-week me-1.5"></i>Lihat Papan Jadwal
        </a>
      </div>

    </div>
  </div>
</div>

<style>
@media print {
  body * {
    visibility: hidden;
  }
  #printableTicket, #printableTicket * {
    visibility: visible;
  }
  #printableTicket {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    border: 1px solid #000 !important;
    box-shadow: none !important;
  }
}
</style>

<?= $this->endSection() ?>
