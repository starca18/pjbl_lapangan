<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
  <title><?= esc($title ?? 'ArenaSport - Reservasi Lapangan Olahraga') ?></title>
  
  <!-- Favicons -->
  <link rel="icon" type="image/svg+xml" href="<?= base_url('favicon.svg?v=2.0') ?>">
  <link rel="alternate icon" type="image/png" href="<?= base_url('favicon.png?v=2.0') ?>">
  <link rel="shortcut icon" href="<?= base_url('favicon.ico?v=2.0') ?>">
  <link rel="apple-touch-icon" href="<?= base_url('apple-touch-icon.png?v=2.0') ?>">
  
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  
  <!-- Bootstrap 5.3 & Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  
  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css?v=' . (@filemtime(FCPATH . 'assets/css/style.css') ?: '20261102_1825')) ?>">
</head>
<body>

  <!-- Navigation Bar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top py-2">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center gap-2" href="<?= base_url() ?>">
        <span class="d-inline-flex align-items-center justify-content-center text-white rounded-3" style="width:36px;height:36px;background:linear-gradient(135deg, #ea580c, #f97316);box-shadow:0 2px 8px rgba(234,88,12,0.3);margin-right:10px;">
          <i class="bi bi-trophy-fill" style="font-size:1.1rem;"></i>
        </span>
        <span>Arena<span style="color:var(--sport-primary);">Sport</span></span>
      </a>
      
      <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarMain">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-lg-3">
          <li class="nav-item">
            <a class="nav-link <?= uri_string() === '' ? 'active' : '' ?>" href="<?= base_url() ?>">Beranda</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= strpos(uri_string(), 'jadwal') === 0 ? 'active' : '' ?>" href="<?= base_url('jadwal') ?>">
              <i class="bi bi-calendar-week me-1"></i>Papan Jadwal
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= strpos(uri_string(), 'booking') === 0 ? 'active' : '' ?>" href="<?= base_url('booking') ?>">
              <i class="bi bi-grid me-1"></i>Pilih Lapangan
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= uri_string() === 'lacak' ? 'active' : '' ?>" href="<?= base_url('lacak') ?>">
              <i class="bi bi-search me-1"></i>Cek Booking
            </a>
          </li>
        </ul>

        <div class="d-flex align-items-center gap-2">
          <?php if (session()->get('is_logged_in')): ?>
            <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-sm px-3" style="border:1.5px solid var(--sport-primary);color:var(--sport-primary);">
              <i class="bi bi-speedometer2 me-1"></i>Dashboard Admin
            </a>
            <a href="<?= base_url('logout') ?>" class="btn btn-light btn-sm text-danger border">
              <i class="bi bi-box-arrow-right"></i>
            </a>
          <?php else: ?>
            <a href="<?= base_url('login') ?>" class="btn btn-light btn-sm text-secondary border px-3">
              <i class="bi bi-person-lock me-1"></i>Staff Login
            </a>
            <a href="<?= base_url('jadwal') ?>" class="btn btn-sport-primary btn-sm px-3 py-1.5">
              <i class="bi bi-calendar-check me-1"></i>Reservasi Sekarang
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </nav>

  <!-- Flash Messages -->
  <?php if (session()->getFlashdata('success')): ?>
    <div class="container mt-3">
      <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
        <i class="bi bi-check-circle-fill me-2 fs-5"></i>
        <div><?= esc(session()->getFlashdata('success')) ?></div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    </div>
  <?php endif; ?>

  <?php if (session()->getFlashdata('error')): ?>
    <div class="container mt-3">
      <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
        <div><?= esc(session()->getFlashdata('error')) ?></div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    </div>
  <?php endif; ?>

  <!-- Content Section -->
  <main>
    <?= $this->renderSection('content') ?>
  </main>

  <!-- Footer -->
  <footer>
    <div class="container">
      <div class="row g-4 mb-4">
        <div class="col-lg-4 col-md-6">
          <div class="d-flex align-items-center gap-2 mb-3">
            <span class="d-inline-flex align-items-center justify-content-center text-white rounded-3 p-1.5" style="width:32px;height:32px;background-color:var(--sport-primary);">
              <i class="bi bi-trophy-fill"></i>
            </span>
            <span class="text-white fw-bold fs-5">ArenaSport Center</span>
          </div>
          <p class="small text-secondary mb-3">
            Pusat gelanggang olahraga modern dengan sistem reservasi jadwal real-time. Nikmati fasilitas lapangan futsal, mini soccer, badminton, bola voli, tenis, dan padel berstandar internasional.
          </p>
          <div class="d-flex gap-3 text-secondary">
            <span><i class="bi bi-geo-alt me-1" style="color:var(--sport-primary);"></i>Jl. Gelanggang Olahraga No. 88</span>
          </div>
        </div>

        <div class="col-lg-2 col-md-6">
          <h6 class="text-white fw-bold mb-3">Pilihan Lapangan</h6>
          <ul class="list-unstyled small d-flex flex-column gap-2 mb-0">
            <li><a href="<?= base_url('booking?category=futsal') ?>">Futsal Vinyl & Rumput</a></li>
            <li><a href="<?= base_url('booking?category=mini-soccer') ?>">Mini Soccer 7v7</a></li>
            <li><a href="<?= base_url('booking?category=badminton') ?>">Badminton Karpet BWF</a></li>
            <li><a href="<?= base_url('booking?category=voli') ?>">Bola Voli Indoor</a></li>
            <li><a href="<?= base_url('booking?category=tenis') ?>">Tenis Hard Court</a></li>
            <li><a href="<?= base_url('booking?category=padel') ?>">Padel Panoramik</a></li>
          </ul>
        </div>

        <div class="col-lg-3 col-md-6">
          <h6 class="text-white fw-bold mb-3">Jam Operasional</h6>
          <ul class="list-unstyled small text-secondary d-flex flex-column gap-2 mb-0">
            <li class="d-flex justify-content-between">
              <span>Senin - Jumat</span>
              <strong class="text-white">07:00 - 23:00</strong>
            </li>
            <li class="d-flex justify-content-between">
              <span>Sabtu - Minggu</span>
              <strong class="text-white">06:00 - 23:00</strong>
            </li>
            <li class="mt-2 text-warning small">
              <i class="bi bi-info-circle me-1"></i>Pemesanan dapat dilakukan online 24 jam.
            </li>
          </ul>
        </div>

        <div class="col-lg-3 col-md-6">
          <h6 class="text-white fw-bold mb-3">Bantuan & Kontak</h6>
          <ul class="list-unstyled small text-secondary d-flex flex-column gap-2 mb-3">
            <li><i class="bi bi-whatsapp me-2 text-success"></i>WhatsApp: +62 812-3456-7890</li>
            <li><i class="bi bi-envelope me-2 text-primary"></i>Email: reservasi@arenasport.id</li>
          </ul>
          <a href="<?= base_url('lacak') ?>" class="btn btn-outline-light btn-sm w-100">
            <i class="bi bi-ticket-perforated me-1"></i>Lacak Kode Booking
          </a>
        </div>
      </div>

      <div class="border-top border-secondary pt-3 d-flex flex-column flex-sm-row justify-content-between align-items-center text-secondary small">
        <p class="mb-0">&copy; <?= date('Y') ?> ArenaSport Reservation System. CodeIgniter 4 Project.</p>
        <p class="mb-0">Dibuat untuk kemudahan pencarian jadwal lapangan olahraga.</p>
      </div>
    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Sport Animations -->
  <?php if (!empty($categories)): ?>
    <script>
      window.ARENA_CATEGORIES = <?= json_encode($categories) ?>;
    </script>
  <?php endif; ?>
  <script src="<?= base_url('assets/js/sport-animations.js?v=' . (@filemtime(FCPATH . 'assets/js/sport-animations.js') ?: '20261102_1915') . '&t=20261102_1915') ?>"></script>
  <?= $this->renderSection('scripts') ?>
</body>
</html>
