<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
  <title><?= esc($title ?? 'Masuk Administrator - ArenaSport') ?></title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css?v=' . (@filemtime(FCPATH . 'assets/css/style.css') ?: '20261102_1825')) ?>">
</head>
<body class="bg-light d-flex align-items-center min-vh-100 py-5">

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5 col-lg-4">
        
        <div class="text-center mb-4">
          <a href="<?= base_url() ?>" class="d-inline-flex align-items-center gap-2 text-decoration-none mb-2">
            <span class="d-inline-flex align-items-center justify-content-center bg-success text-white rounded-3 p-2" style="width:40px;height:40px;">
              <i class="bi bi-shield-lock-fill fs-5"></i>
            </span>
            <span class="fs-4 fw-bold text-dark">Arena<span class="text-success">Sport</span></span>
          </a>
          <p class="text-secondary small">Panel Masuk Pengelola Gelanggang & Staff</p>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
          <div class="alert alert-danger alert-dismissible fade show small" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-1"></i>
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
          </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
          <div class="alert alert-success alert-dismissible fade show small" role="alert">
            <i class="bi bi-check-circle-fill me-1"></i>
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
          </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
          <form action="<?= base_url('login/process') ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
              <label class="form-label small fw-bold text-secondary">Username</label>
              <div class="input-group">
                <span class="input-group-text bg-light text-muted border-end-0">
                  <i class="bi bi-person"></i>
                </span>
                <input type="text" name="username" class="form-control border-start-0" placeholder="Masukkan username" required autofocus value="admin">
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label small fw-bold text-secondary">Kata Sandi</label>
              <div class="input-group">
                <span class="input-group-text bg-light text-muted border-end-0">
                  <i class="bi bi-key"></i>
                </span>
                <input type="password" name="password" class="form-control border-start-0" placeholder="Masukkan kata sandi" required value="admin123">
              </div>
            </div>

            <button type="submit" class="btn btn-sport-primary w-100 py-2.5 fw-bold mb-3">
              <i class="bi bi-box-arrow-in-right me-1.5"></i>Masuk ke Dashboard
            </button>
          </form>

          <div class="alert alert-info-subtle border border-info-subtle p-2.5 rounded-3 mb-0 small text-info-emphasis">
            <div class="fw-bold mb-1"><i class="bi bi-info-circle me-1"></i>Akun Demo Default:</div>
            <div>Username: <code>admin</code></div>
            <div>Password: <code>admin123</code></div>
          </div>
        </div>

        <div class="text-center mt-4">
          <a href="<?= base_url() ?>" class="text-secondary small text-decoration-none">
            <i class="bi bi-arrow-left me-1"></i>Kembali ke Halaman Publik
          </a>
        </div>

      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
