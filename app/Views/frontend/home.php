<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<section class="hero-section text-center text-lg-start">
  <!-- Shimmer & Sparkle Effects Layer -->
  <div class="hero-sparkles-container" aria-hidden="true">
    <span class="hero-sparkle sp-1">✦</span>
    <span class="hero-sparkle sp-2">✧</span>
    <span class="hero-sparkle sp-3">✦</span>
    <span class="hero-sparkle sp-4">✧</span>
    <span class="hero-sparkle sp-5">✦</span>
    <span class="hero-sparkle sp-6">✧</span>
    <span class="hero-sparkle sp-7">✦</span>
    <div class="hero-shimmer-sweep"></div>
  </div>
  <div class="container position-relative" style="z-index: 2;">
    <div class="row align-items-center g-4">
      <div class="col-lg-7">
        <h1 class="hero-title mb-3">
          Sewa Lapangan Olahraga Favorit Tanpa Ribet
        </h1>
        <p class="hero-subtitle mb-4">
          Cek jadwal langsung dan sewa lapangan olahraga favorit Anda tanpa ribet.
        </p>
        <div class="d-flex flex-wrap gap-2 gap-md-3 justify-content-center justify-content-lg-start">
          <a href="<?= base_url('jadwal') ?>" class="btn btn-sport btn-shimmer d-inline-flex align-items-center">
            <i class="bi bi-calendar3 me-2"></i>Cek Jadwal Lapangan
          </a>
          <a href="#pilih-olahraga" class="btn btn-outline-light px-3 px-md-4 py-2 fw-semibold rounded-3 d-inline-flex align-items-center">
            <i class="bi bi-grid me-2"></i>Pilih Lapangan
          </a>
          <a href="<?= base_url('lacak') ?>" class="btn btn-outline-light px-3 px-md-4 py-2 fw-semibold rounded-3 d-inline-flex align-items-center">
            <i class="bi bi-ticket-perforated me-2"></i>Lacak Kode Booking
          </a>
        </div>
      </div>

      <div class="col-lg-5">
        <div class="bg-white rounded-4 p-4 text-dark shadow-lg">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">
              <i class="bi bi-clock-history me-2" style="color:var(--sport-primary);"></i>Cek Jadwal Cepat
            </h5>
            <span class="badge px-2.5 py-1" style="background-color:#ffedd5;color:var(--sport-primary-dark);border:1px solid #fed7aa;">Hari Ini</span>
          </div>
          <p class="text-secondary small mb-3">
            Pilih tanggal dan jenis olahraga untuk cek jam kosong.
          </p>

          <form action="<?= base_url('jadwal') ?>" method="get">
            <div class="mb-3">
              <label class="form-label small fw-bold text-secondary">Tanggal Reservasi</label>
              <input type="date" name="date" class="form-control" value="<?= date('Y-m-d') ?>" min="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="mb-3">
              <label class="form-label small fw-bold text-secondary">Cabang Olahraga</label>
              <select name="category" class="form-select">
                <option value="">Semua Cabang Olahraga</option>
                <?php foreach ($categories as $cat): ?>
                  <option value="<?= $cat['id'] ?>"><?= esc($cat['name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <button type="submit" class="btn btn-sport-primary w-100 py-2.5">
              <i class="bi bi-calendar-check me-1"></i>Cek Jadwal Lapangan
            </button>
          </form>
          <div class="text-center mt-3 pt-2 border-top">
            <a href="<?= base_url('lacak') ?>" class="text-secondary small text-decoration-none">
              <i class="bi bi-ticket-perforated me-1 text-warning"></i>Sudah punya kode booking? <strong class="text-dark">Lacak di sini &rarr;</strong>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Interactive Sport Selection Section with Isometric Animated Courts -->
<section class="py-5 bg-white border-bottom" id="pilih-olahraga">
  <div class="container">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4">
      <div>
        <h2 class="fw-bold mb-0">Pilihan Cabang Olahraga</h2>
      </div>
      <div class="mt-3 mt-md-0 d-flex gap-2">
        <a href="<?= base_url('jadwal') ?>" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1.5">
          <i class="bi bi-calendar3 me-1"></i>Cek Jadwal Semua
        </a>
        <a href="#daftar-lapangan" class="btn btn-sm rounded-pill px-3 py-1.5 text-white" style="background-color:var(--sport-primary);">
          Semua Lapangan (<?= count($courts) ?>)<i class="bi bi-arrow-down ms-1"></i>
        </a>
      </div>
    </div>

    <!-- Animated Sport Cards Grid -->
    <div class="row g-4" id="sportSelectionGrid">
      <!-- Generated dynamically by sport-animations.js -->
    </div>
  </div>
</section>

<!-- Highlight: Visual Status Banner -->
<section class="py-4 bg-light">
  <div class="container">
    <div class="row g-3">
      <div class="col-md-4">
        <div class="d-flex align-items-center gap-3 p-3 bg-white rounded-3 border">
          <div class="d-inline-flex p-3 rounded-circle bg-success-subtle text-success">
            <i class="bi bi-calendar-check fs-4"></i>
          </div>
          <div>
            <h6 class="fw-bold mb-1">Jadwal Real-Time</h6>
            <p class="small text-muted mb-0">Pantau jam kosong langsung tanpa perlu chat admin.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="d-flex align-items-center gap-3 p-3 bg-white rounded-3 border">
          <div class="d-inline-flex p-3 rounded-circle bg-primary-subtle text-primary">
            <i class="bi bi-lightning-charge fs-4"></i>
          </div>
          <div>
            <h6 class="fw-bold mb-1">Konfirmasi Cepat</h6>
            <p class="small text-muted mb-0">Slot jam otomatis terkunci begitu reservasi selesai.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="d-flex align-items-center gap-3 p-3 bg-white rounded-3 border">
          <div class="d-inline-flex p-3 rounded-circle bg-warning-subtle text-warning">
            <i class="bi bi-ticket-detailed fs-4"></i>
          </div>
          <div>
            <h6 class="fw-bold mb-1">E-Tiket Digital</h6>
            <p class="small text-muted mb-0">Cukup tunjukkan kode booking saat tiba di lokasi.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Courts Catalog Section -->
<section class="py-5" id="daftar-lapangan">
  <div class="container">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4">
      <div>
        <h2 class="fw-bold mb-0">Daftar Lapangan Olahraga</h2>
      </div>
      <a href="<?= base_url('booking#daftar-lapangan') ?>" class="btn btn-sport-outline mt-3 mt-md-0">
        Lihat Semua Lapangan (<?= count($courts) ?>)<i class="bi bi-arrow-right ms-2"></i>
      </a>
    </div>

    <div class="row g-4" id="homeCourtsGrid">
      <?php foreach ($courts as $court): ?>
        <div class="col-lg-4 col-md-6 court-col-item" data-category-slug="<?= esc($court['category_slug'] ?? '') ?>">
          <div class="card card-court h-100">
            <div class="court-img-wrapper">
              <span class="court-type-pill"><?= esc($court['court_type']) ?></span>
              <span class="court-category-pill"><?= esc($court['category_name']) ?></span>
              <img src="<?= base_url('assets/images/courts/' . esc($court['image'])) ?>" alt="<?= esc($court['name']) ?>">
            </div>
            <div class="card-body p-4 d-flex flex-column">
              <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="badge bg-secondary-subtle text-secondary font-monospace"><?= esc($court['code']) ?></span>
                <span class="text-primary fw-bold" style="color:var(--sport-primary) !important;"><?= rupiah($court['price_per_hour']) ?> <span class="text-muted fw-normal small">/ jam</span></span>
              </div>
              <h5 class="card-title fw-bold mb-2"><?= esc($court['name']) ?></h5>
              <p class="text-secondary small mb-3 flex-grow-1">
                <?= esc($court['description']) ?>
              </p>
              
              <div class="d-flex align-items-center gap-2 mb-3 text-secondary small">
                <i class="bi bi-layers text-primary"></i>
                <span>Lantai: <strong><?= esc($court['floor_type'] ?? 'Standar') ?></strong></span>
              </div>

              <div class="d-grid gap-2">
                <a href="<?= base_url('booking/detail/' . $court['id']) ?>" class="btn btn-sport-primary py-2">
                  <i class="bi bi-calendar-plus me-1.5"></i>Pilih Jam & Pesan
                </a>
                <a href="<?= base_url('jadwal?court=' . $court['id']) ?>" class="btn btn-light border py-1.5 text-secondary small">
                  <i class="bi bi-table me-1"></i>Lihat Jadwal Hari Ini
                </a>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Today's Schedule Matrix Teaser -->
<section class="py-5 bg-white border-top border-bottom">
  <div class="container">
    <div class="text-center max-w-xl mx-auto mb-4">
      <h2 class="fw-bold mb-1">Jadwal Hari Ini</h2>
      <p class="text-secondary small mb-0">
        <?= tanggal_indonesia($today) ?>
      </p>
    </div>

    <div class="schedule-table-wrapper">
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
          <?php foreach ($courts as $court): ?>
            <tr>
              <td class="sticky-col">
                <div class="d-flex flex-column">
                  <span class="fw-bold text-dark"><?= esc($court['name']) ?></span>
                  <span class="text-muted small"><?= esc($court['category_name']) ?> &bull; <?= rupiah($court['price_per_hour']) ?>/jam</span>
                </div>
              </td>
              <?php foreach ($timeSlots as $time => $label): ?>
                <?php 
                  $isOccupied = isset($slotsByCourt[$court['id']][$time]);
                  $slotData   = $isOccupied ? $slotsByCourt[$court['id']][$time] : null;
                ?>
                <td>
                  <?php if (!$isOccupied): ?>
                    <a href="<?= base_url('booking/detail/' . $court['id'] . '?date=' . $today . '&slot=' . $time) ?>" 
                       class="slot-badge slot-available" 
                       title="Klik untuk reservasi slot ini">
                      <span>Kosong</span>
                    </a>
                  <?php elseif ($slotData['booking_status'] === 'pending'): ?>
                    <div class="slot-badge slot-pending" title="Menunggu Konfirmasi">
                      <span>Proses</span>
                    </div>
                  <?php else: ?>
                    <div class="slot-badge slot-booked" title="Sudah Dibooking">
                      <span>Penuh</span>
                    </div>
                  <?php endif; ?>
                </td>
              <?php endforeach; ?>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <div class="text-center mt-4">
      <a href="<?= base_url('jadwal') ?>" class="btn btn-sport-primary px-4 py-2">
        <i class="bi bi-calendar2-range me-2"></i>Lihat Jadwal Selengkapnya
      </a>
    </div>
  </div>
</section>

<!-- How to Book Steps -->
<section class="py-5 bg-light">
  <div class="container">
    <div class="text-center mb-5">
      <h3 class="fw-bold">4 Langkah Mudah Reservasi Lapangan</h3>
      <p class="text-secondary">Pesan lapangan favorit dalam hitungan detik.</p>
    </div>

    <div class="row g-4 text-center">
      <div class="col-md-3 how-to-step">
        <div class="bg-white p-4 rounded-3 border h-100">
          <div class="d-inline-flex align-items-center justify-content-center text-white rounded-circle mb-3" style="width:48px;height:48px;background-color:var(--sport-primary);">
            <strong class="fs-5">1</strong>
          </div>
          <h6 class="fw-bold mb-2">Pilih Lapangan</h6>
          <p class="small text-secondary mb-0">Pilih cabang olahraga yang ingin dimainkan.</p>
        </div>
      </div>
      <div class="col-md-3 how-to-step">
        <div class="bg-white p-4 rounded-3 border h-100">
          <div class="d-inline-flex align-items-center justify-content-center text-white rounded-circle mb-3" style="width:48px;height:48px;background-color:var(--sport-primary);">
            <strong class="fs-5">2</strong>
          </div>
          <h6 class="fw-bold mb-2">Cek Jam Main</h6>
          <p class="small text-secondary mb-0">Pilih tanggal dan slot jam yang masih kosong.</p>
        </div>
      </div>
      <div class="col-md-3 how-to-step">
        <div class="bg-white p-4 rounded-3 border h-100">
          <div class="d-inline-flex align-items-center justify-content-center text-white rounded-circle mb-3" style="width:48px;height:48px;background-color:var(--sport-primary);">
            <strong class="fs-5">3</strong>
          </div>
          <h6 class="fw-bold mb-2">Isi Data Diri</h6>
          <p class="small text-secondary mb-0">Ketik nama, nomor WhatsApp, dan cara bayar.</p>
        </div>
      </div>
      <div class="col-md-3 how-to-step">
        <div class="bg-white p-4 rounded-3 border h-100">
          <div class="d-inline-flex align-items-center justify-content-center text-white rounded-circle mb-3" style="width:48px;height:48px;background-color:var(--sport-primary);">
            <strong class="fs-5">4</strong>
          </div>
          <h6 class="fw-bold mb-2">Terima E-Tiket</h6>
          <p class="small text-secondary mb-0">Simpan kode booking untuk tunjukkan di lokasi.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
  if (window.ArenaSportAnimations) {
    ArenaSportAnimations.renderSportCards('#sportSelectionGrid', {
      baseUrl: '<?= base_url() ?>',
      categories: <?= json_encode($categories) ?>,
      onSelect: function (slug, categoryId, cardEl) {
        const courtItems = document.querySelectorAll('.court-col-item');
        courtItems.forEach(item => {
          const itemSlug = (item.dataset.categorySlug || '').toLowerCase();
          const match = !slug || itemSlug === slug.toLowerCase();
          item.style.display = match ? '' : 'none';
        });

        // Smooth scroll straight down to the courts list
        const targetSection = document.getElementById('daftar-lapangan');
        if (targetSection) {
          targetSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
      }
    });
  }
});
</script>
<?= $this->endSection() ?>
