<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
  <title><?= esc($title ?? 'Panel Pengelola - ArenaSport') ?></title>
  
  <!-- Favicons -->
  <link rel="icon" type="image/svg+xml" href="<?= base_url('favicon.svg?v=2.0') ?>">
  <link rel="alternate icon" type="image/png" href="<?= base_url('favicon.png?v=2.0') ?>">
  <link rel="shortcut icon" href="<?= base_url('favicon.ico?v=2.0') ?>">
  <link rel="apple-touch-icon" href="<?= base_url('apple-touch-icon.png?v=2.0') ?>">
  
  <!-- Google Fonts: Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
  
  <!-- Bootstrap 5.3 & Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css?v=' . (@filemtime(FCPATH . 'assets/css/style.css') ?: '20261102_1900')) ?>">

  <style>
    :root {
      --admin-sidebar-bg: #0b1120;
      --admin-sidebar-border: rgba(255, 255, 255, 0.08);
      --admin-topbar-h: 64px;
      --admin-body-bg: #f8fafc;
    }
    body.admin-body {
      background-color: var(--admin-body-bg);
      font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
      color: #0f172a;
      min-height: 100vh;
    }
    .admin-wrapper {
      display: flex;
      min-height: 100vh;
    }
    /* Modern Sidebar */
    .admin-sidebar {
      width: 270px;
      min-width: 270px;
      background: var(--admin-sidebar-bg);
      border-right: 1px solid var(--admin-sidebar-border);
      display: flex;
      flex-direction: column;
      position: sticky;
      top: 0;
      height: 100vh;
      overflow-y: auto;
      z-index: 1020;
      transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .admin-sidebar-header {
      padding: 1.25rem 1.25rem 1rem;
      border-bottom: 1px solid var(--admin-sidebar-border);
    }
    .admin-sidebar-brand {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      text-decoration: none;
      color: #ffffff;
    }
    .admin-sidebar-brand:hover {
      color: #ffffff;
    }
    .admin-brand-icon {
      width: 38px;
      height: 38px;
      border-radius: 10px;
      background: linear-gradient(135deg, #ea580c, #f97316);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      color: #ffffff;
      font-size: 1.2rem;
      box-shadow: 0 4px 12px rgba(234, 88, 12, 0.35);
      flex-shrink: 0;
    }
    .admin-nav-section-title {
      font-size: 0.68rem;
      font-weight: 700;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      color: #64748b;
      padding: 0.85rem 1.25rem 0.35rem;
    }
    .admin-nav-link {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0.68rem 1rem;
      margin: 2px 10px;
      border-radius: 9px;
      color: #94a3b8;
      font-size: 0.88rem;
      font-weight: 500;
      text-decoration: none;
      transition: all 0.15s ease;
      white-space: nowrap;
    }
    .admin-nav-link-content {
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }
    .admin-nav-link i {
      font-size: 1.15rem;
      color: #64748b;
      transition: color 0.15s ease;
      flex-shrink: 0;
    }
    .admin-nav-link:hover {
      color: #ffffff;
      background: rgba(255, 255, 255, 0.06);
    }
    .admin-nav-link:hover i {
      color: #f97316;
    }
    .admin-nav-link.active {
      color: #ffffff;
      font-weight: 700;
      background: linear-gradient(90deg, rgba(234, 88, 12, 0.22) 0%, rgba(234, 88, 12, 0.08) 100%);
      border-left: 3px solid #f97316;
    }
    .admin-nav-link.active i {
      color: #f97316;
    }
    .admin-sidebar-footer {
      margin-top: auto;
      padding: 1rem;
      border-top: 1px solid var(--admin-sidebar-border);
      background: rgba(0, 0, 0, 0.2);
    }
    .admin-user-card {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 0.75rem;
    }
    .admin-user-avatar {
      width: 36px;
      height: 36px;
      border-radius: 8px;
      background: rgba(234, 88, 12, 0.2);
      border: 1px solid rgba(234, 88, 12, 0.4);
      color: #fb923c;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 0.85rem;
      flex-shrink: 0;
    }
    /* Main Content Wrapper */
    .admin-main-wrap {
      flex: 1;
      display: flex;
      flex-direction: column;
      min-width: 0;
    }
    .admin-topbar {
      height: var(--admin-topbar-h);
      background: #ffffff;
      border-bottom: 1px solid #e2e8f0;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 1.75rem;
      position: sticky;
      top: 0;
      z-index: 1010;
    }
    .live-pulse-dot {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: #16a34a;
      box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.2);
      display: inline-block;
      animation: pulseLive 2s infinite ease-in-out;
    }
    @keyframes pulseLive {
      0%, 100% { box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.2); }
      50% { box-shadow: 0 0 0 6px rgba(22, 163, 74, 0.35); }
    }
    /* Responsive Offcanvas Sidebar */
    @media (max-width: 991.98px) {
      .admin-sidebar {
        position: fixed;
        left: -270px;
        top: 0;
        bottom: 0;
      }
      .admin-sidebar.show {
        left: 0;
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.5);
      }
      .admin-topbar {
        padding: 0 1rem;
      }
    }
  </style>
</head>
<body class="admin-body">

  <div class="admin-wrapper">
    <!-- Sidebar Navigation -->
    <aside class="admin-sidebar" id="adminSidebar">
      <div class="admin-sidebar-header">
        <a href="<?= base_url('admin/dashboard') ?>" class="admin-sidebar-brand">
          <span class="admin-brand-icon">
            <i class="bi bi-trophy-fill"></i>
          </span>
          <div>
            <div class="fw-bold fs-6 lh-1">Arena<span style="color:#f97316;">Sport</span></div>
            <div class="d-flex align-items-center gap-1.5 mt-1">
              <span class="badge rounded-pill" style="font-size:0.62rem; font-weight:700; background:rgba(234, 88, 12, 0.2); color:#fb923c; border:1px solid rgba(234, 88, 12, 0.3); letter-spacing:0.04em; padding:2px 7px;">
                PENGELOLA
              </span>
              <span class="text-white-50 small" style="font-size:0.65rem;">v2.1</span>
            </div>
          </div>
        </a>
      </div>

      <div class="py-2 flex-grow-1">
        <div class="admin-nav-section-title">Menu Utama</div>
        <a class="admin-nav-link <?= uri_string() === 'admin' || uri_string() === 'admin/dashboard' ? 'active' : '' ?>" href="<?= base_url('admin/dashboard') ?>">
          <span class="admin-nav-link-content">
            <i class="bi bi-grid-fill"></i>Dashboard
          </span>
        </a>
        <a class="admin-nav-link <?= strpos(uri_string(), 'admin/jadwal') === 0 ? 'active' : '' ?>" href="<?= base_url('admin/jadwal') ?>">
          <span class="admin-nav-link-content">
            <i class="bi bi-calendar3-week"></i>Master Jadwal
          </span>
        </a>

        <div class="admin-nav-section-title mt-2">Operasional Gelanggang</div>
        <a class="admin-nav-link <?= uri_string() === 'admin/bookings' ? 'active' : '' ?>" href="<?= base_url('admin/bookings') ?>">
          <span class="admin-nav-link-content">
            <i class="bi bi-journal-bookmark-fill"></i>Daftar Reservasi
          </span>
        </a>
        <a class="admin-nav-link <?= uri_string() === 'admin/bookings/create' ? 'active' : '' ?>" href="<?= base_url('admin/bookings/create') ?>">
          <span class="admin-nav-link-content">
            <i class="bi bi-plus-circle-fill"></i>Tambah Walk-in
          </span>
          <span class="badge bg-success-subtle text-success small" style="font-size:0.65rem;">Kasir</span>
        </a>
        <a class="admin-nav-link <?= strpos(uri_string(), 'admin/courts') === 0 ? 'active' : '' ?>" href="<?= base_url('admin/courts') ?>">
          <span class="admin-nav-link-content">
            <i class="bi bi-bounding-box-circles"></i>Data Lapangan
          </span>
        </a>

        <div class="admin-nav-section-title mt-2">Akses Cepat</div>
        <a class="admin-nav-link" href="<?= base_url() ?>" target="_blank">
          <span class="admin-nav-link-content">
            <i class="bi bi-globe2"></i>Lihat Website
          </span>
          <i class="bi bi-box-arrow-up-right small text-muted" style="font-size:0.75rem;"></i>
        </a>
      </div>

      <!-- User Profile & Logout -->
      <div class="admin-sidebar-footer">
        <div class="admin-user-card">
          <div class="d-flex align-items-center gap-2.5 overflow-hidden">
            <div class="admin-user-avatar">
              <?= strtoupper(substr(session()->get('full_name') ?? 'Admin', 0, 2)) ?>
            </div>
            <div class="overflow-hidden">
              <div class="text-white fw-bold small text-truncate" style="max-width:130px;">
                <?= esc(session()->get('full_name') ?? 'Administrator') ?>
              </div>
              <div class="text-secondary small" style="font-size:0.7rem;">@<?= esc(session()->get('username') ?? 'admin') ?></div>
            </div>
          </div>
          <a href="<?= base_url('logout') ?>" class="btn btn-sm btn-outline-danger border-0 p-1.5 rounded-2" title="Keluar / Logout">
            <i class="bi bi-box-arrow-right fs-5"></i>
          </a>
        </div>
      </div>
    </aside>

    <!-- Main Content Area -->
    <div class="admin-main-wrap">
      <!-- Topbar Header -->
      <header class="admin-topbar">
        <div class="d-flex align-items-center gap-3">
          <button class="btn btn-sm btn-light border d-lg-none" type="button" id="sidebarToggleBtn" aria-label="Toggle Sidebar">
            <i class="bi bi-list fs-5"></i>
          </button>
          <div class="d-none d-sm-flex align-items-center gap-2 text-secondary small fw-medium">
            <span class="live-pulse-dot"></span>
            <span>Gelanggang Buka (07:00 - 23:00 WIB)</span>
          </div>
        </div>

        <div class="d-flex align-items-center gap-2 gap-sm-3">
          <div class="d-none d-md-flex align-items-center gap-1 text-secondary small bg-light px-3 py-1.5 rounded-pill border">
            <i class="bi bi-calendar3 text-primary me-2"></i>
            <span class="fw-semibold text-dark"><?= esc(tanggal_indonesia(date('Y-m-d'))) ?></span>
          </div>
          <a href="<?= base_url() ?>" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
            <i class="bi bi-box-arrow-up-right me-1.5"></i>Web Publik
          </a>
          <a href="<?= base_url('admin/bookings/create') ?>" class="btn btn-sm btn-sport-primary rounded-pill px-3">
            <i class="bi bi-plus-lg me-1"></i>Walk-in
          </a>
        </div>
      </header>

      <!-- Content Container -->
      <main class="p-3 p-md-4 flex-grow-1">
        <?php if (session()->getFlashdata('success')): ?>
          <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4 rounded-3 border-0 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5 text-success"></i>
            <div class="fw-medium"><?= esc(session()->getFlashdata('success')) ?></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
          <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4 rounded-3 border-0 shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2 fs-5 text-danger"></i>
            <div class="fw-medium"><?= esc(session()->getFlashdata('error')) ?></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
      </main>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Responsive sidebar toggle
    const toggleBtn = document.getElementById('sidebarToggleBtn');
    const sidebar = document.getElementById('adminSidebar');
    if (toggleBtn && sidebar) {
      toggleBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        sidebar.classList.toggle('show');
      });
      document.addEventListener('click', function(e) {
        if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
          sidebar.classList.remove('show');
        }
      });
    }
  </script>
  <?= $this->renderSection('scripts') ?>
</body>
</html>
