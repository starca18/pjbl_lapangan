<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="bg-white border-bottom py-4">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-1 small">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
        <li class="breadcrumb-item active" aria-current="page">Lacak Reservasi</li>
      </ol>
    </nav>
    <h2 class="fw-bold mb-1">Cek Status Reservasi</h2>
    <p class="text-secondary small mb-0">
      Masukkan kode booking atau nomor HP untuk cek status pemesanan.
    </p>
  </div>
</div>

<div class="container py-5">
  <div class="row justify-content-center mb-5">
    <div class="col-lg-7">
      <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white text-center">
        <div class="d-inline-flex align-items-center justify-content-center bg-success-subtle text-success rounded-circle p-3 mb-3 mx-auto" style="width:64px;height:64px;">
          <i class="bi bi-search fs-3"></i>
        </div>
        <h4 class="fw-bold mb-2">Cari Data Pemesanan Anda</h4>
        <p class="text-secondary small mb-4">
          Gunakan kode booking (contoh: <code>BK-<?= date('Ymd') ?>-001</code>) atau nomor WhatsApp pemesan.
        </p>

        <form action="<?= base_url('lacak') ?>" method="get">
          <div class="input-group input-group-lg mb-3">
            <span class="input-group-text bg-light border-end-0">
              <i class="bi bi-ticket-perforated text-muted"></i>
            </span>
            <input type="text" name="q" class="form-control border-start-0" placeholder="Ketik kode booking atau nomor HP..." value="<?= esc($keyword) ?>" required autofocus>
            <button class="btn btn-sport-primary px-4 fw-bold" type="submit">
              Cari
            </button>
          </div>
        </form>

        <div class="small text-muted">
          Butuh bantuan? Hubungi WhatsApp <strong>0812-3456-7890</strong>.
        </div>
      </div>
    </div>
  </div>

  <?php if (!empty($keyword)): ?>
    <div class="row justify-content-center">
      <div class="col-lg-9">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="fw-bold mb-0">Hasil Pencarian untuk: "<?= esc($keyword) ?>"</h5>
          <span class="badge bg-secondary"><?= count($results) ?> Data Ditemukan</span>
        </div>

        <?php if (empty($results)): ?>
          <div class="card border-0 shadow-sm rounded-3 p-5 text-center bg-white">
            <i class="bi bi-emoji-neutral text-secondary display-4 d-block mb-2"></i>
            <h5 class="fw-bold">Tidak Menemukan Data Reservasi</h5>
            <p class="text-secondary small mb-3">
              Periksa kembali kode booking atau nomor HP yang Anda masukkan.
            </p>
            <div>
              <a href="<?= base_url('lacak') ?>" class="btn btn-outline-secondary btn-sm">Cari Ulang</a>
            </div>
          </div>
        <?php else: ?>
          <div class="d-flex flex-column gap-3">
            <?php foreach ($results as $item): ?>
              <div class="card border-0 shadow-sm rounded-3 p-4 bg-white">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                  <div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                      <span class="font-monospace fw-bold text-success fs-5"><?= esc($item['booking_code']) ?></span>
                      <div><?= badge_status($item['status']) ?></div>
                      <div><?= badge_payment($item['payment_status']) ?></div>
                    </div>
                    <h5 class="fw-bold mb-1 text-dark"><?= esc($item['court_name']) ?></h5>
                    <div class="text-secondary small d-flex flex-wrap gap-3">
                      <span><i class="bi bi-person me-1"></i><?= esc($item['customer_name']) ?></span>
                      <span><i class="bi bi-calendar me-1"></i><?= tanggal_indonesia($item['booking_date']) ?></span>
                      <span><i class="bi bi-clock me-1"></i><?= substr($item['start_time'], 0, 5) ?> - <?= substr($item['end_time'], 0, 5) ?> WIB (<?= $item['total_hours'] ?> Jam)</span>
                    </div>
                  </div>

                  <div class="d-flex flex-column align-items-md-end gap-2">
                    <div class="text-muted small">Total Tagihan:</div>
                    <div class="fw-bold fs-4 text-dark"><?= rupiah($item['total_price']) ?></div>
                    <a href="<?= base_url('booking/success/' . $item['booking_code']) ?>" class="btn btn-outline-success btn-sm px-3">
                      <i class="bi bi-eye me-1"></i>Lihat E-Tiket
                    </a>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

      </div>
    </div>
  <?php endif; ?>

</div>

<?= $this->endSection() ?>
