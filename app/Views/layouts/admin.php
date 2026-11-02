<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= esc($title ?? 'Admin Panel - ArenaSport') ?></title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body class="bg-light">

  <!-- Admin Top Navbar -->
  <header class="navbar navbar-dark sticky-top p-2 shadow-sm" style="background-color:#1c1917;">
    <div class="container-fluid px-3">
      <div class="d-flex align-items-center gap-2">
        <!-- Mobile sidebar toggle -->
        <button class="btn btn-sm btn-outline-light d-md-none me-1" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarInner" aria-expanded="false" aria-label="Toggle menu">
          <i class="bi bi-list fs-5"></i>
        </button>
        <a class="navbar-brand d-flex align-items-center gap-2" href="<?= base_url('admin/dashboard') ?>">
          <span class="text-white rounded p-1 d-inline-flex align-items-center justify-content-center" style="width:28px;height:28px;background-color:var(--sport-primary);">
            <i class="bi bi-shield-check"></i>
          </span>
          <span class="text-white fw-bold fs-6">ArenaSport Admin</span>
        </a>
      </div>

      <div class="d-flex align-items-center gap-3">
        <a href="<?= base_url() ?>" target="_blank" class="btn btn-outline-light btn-sm">
          <i class="bi bi-box-arrow-up-right me-1"></i>Lihat Website
        </a>
        <div class="dropdown">
          <button class="btn btn-dark btn-sm dropdown-toggle d-flex align-items-center gap-2 border" type="button" data-bs-toggle="dropdown">
            <i class="bi bi-person-circle fs-6"></i>
            <span><?= esc(session()->get('full_name') ?? 'Admin') ?></span>
          </button>
          <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
            <li><span class="dropdown-item-text text-muted small">Masuk sebagai: <strong><?= esc(session()->get('username')) ?></strong></span></li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">
                <i class="bi bi-box-arrow-right me-2"></i>Keluar
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </header>

  <div class="container-fluid">
    <div class="row">
      <!-- Admin Sidebar -->
      <nav class="col-md-3 col-lg-2 admin-sidebar p-0" id="sidebarMenu">
        <div class="collapse d-md-block" id="sidebarInner">
        <div class="pt-3 pb-5">
          <div class="px-3 mb-2 text-uppercase text-secondary small fw-bold" style="font-size:0.7rem; letter-spacing:1px;">Utama</div>
          <a class="admin-nav-item <?= uri_string() === 'admin' || uri_string() === 'admin/dashboard' ? 'active' : '' ?>" href="<?= base_url('admin/dashboard') ?>">
            <i class="bi bi-speedometer2"></i>Dashboard
          </a>
          <a class="admin-nav-item <?= strpos(uri_string(), 'admin/jadwal') === 0 ? 'active' : '' ?>" href="<?= base_url('admin/jadwal') ?>">
            <i class="bi bi-calendar3"></i>Master Jadwal
          </a>

          <div class="px-3 mt-4 mb-2 text-uppercase text-secondary small fw-bold" style="font-size:0.7rem; letter-spacing:1px;">Transaksi & Lapangan</div>
          <a class="admin-nav-item <?= uri_string() === 'admin/bookings' ? 'active' : '' ?>" href="<?= base_url('admin/bookings') ?>">
            <i class="bi bi-journal-bookmark"></i>Daftar Reservasi
          </a>
          <a class="admin-nav-item <?= uri_string() === 'admin/bookings/create' ? 'active' : '' ?>" href="<?= base_url('admin/bookings/create') ?>">
            <i class="bi bi-plus-circle"></i>Tambah Walk-in
          </a>
          <a class="admin-nav-item <?= strpos(uri_string(), 'admin/courts') === 0 ? 'active' : '' ?>" href="<?= base_url('admin/courts') ?>">
            <i class="bi bi-grid-3x3-gap"></i>Data Lapangan
          </a>

          <div class="px-3 mt-4 mb-2 text-uppercase text-secondary small fw-bold" style="font-size:0.7rem; letter-spacing:1px;">Sistem</div>
          <a class="admin-nav-item text-danger" href="<?= base_url('logout') ?>">
            <i class="bi bi-box-arrow-right"></i>Keluar
          </a>
        </div>
        </div>
      </nav>

      <!-- Main Admin Content Area -->
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
        
        <?php if (session()->getFlashdata('success')): ?>
          <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
            <div><?= session()->getFlashdata('success') ?></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
          <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
            <div><?= session()->getFlashdata('error') ?></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
      </main>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <?= $this->renderSection('scripts') ?>
</body>
</html>
