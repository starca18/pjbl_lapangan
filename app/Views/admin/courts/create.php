<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="mb-4">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-1 small">
      <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="<?= base_url('admin/courts') ?>">Lapangan</a></li>
      <li class="breadcrumb-item active" aria-current="page">Tambah Lapangan</li>
    </ol>
  </nav>
  <h3 class="fw-bold mb-1">Tambah Lapangan Olahraga Baru</h3>
  <p class="text-secondary small mb-0">Lengkapi formulir spesifikasi lapangan dan tarif per jam.</p>
</div>

<div class="row">
  <div class="col-lg-8">
    <div class="card border-0 shadow-sm rounded-3 p-4 bg-white">
      <form action="<?= base_url('admin/courts/store') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="row g-3 mb-3">
          <div class="col-md-4">
            <label class="form-label small fw-bold text-secondary">Kode Lapangan <span class="text-danger">*</span></label>
            <input type="text" name="code" class="form-control text-uppercase font-monospace" placeholder="Contoh: FUT-03" required value="<?= old('code') ?>">
          </div>

          <div class="col-md-8">
            <label class="form-label small fw-bold text-secondary">Nama Lapangan <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" placeholder="Contoh: Lapangan Futsal Vinyl B" required value="<?= old('name') ?>">
          </div>

          <div class="col-md-6">
            <label class="form-label small fw-bold text-secondary">Cabang Olahraga <span class="text-danger">*</span></label>
            <select name="category_id" class="form-select" required>
              <option value="">-- Pilih Cabang Olahraga --</option>
              <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>" <?= old('category_id') == $cat['id'] ? 'selected' : '' ?>>
                  <?= esc($cat['name']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label small fw-bold text-secondary">Tipe Venue <span class="text-danger">*</span></label>
            <select name="court_type" class="form-select">
              <option value="Indoor">Indoor (Dalam Ruangan)</option>
              <option value="Outdoor">Outdoor (Luar Ruangan)</option>
              <option value="Semi-Indoor">Semi-Indoor (Atap Canopy)</option>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label small fw-bold text-secondary">Jenis Permukaan Lantai</label>
            <input type="text" name="floor_type" class="form-control" placeholder="Contoh: Vinyl Taraflex 7mm / Rumput Sintetis" value="<?= old('floor_type') ?>">
          </div>

          <div class="col-md-6">
            <label class="form-label small fw-bold text-secondary">Tarif Sewa per Jam (Rp) <span class="text-danger">*</span></label>
            <input type="number" step="1000" name="price_per_hour" class="form-control" placeholder="Contoh: 150000" required value="<?= old('price_per_hour') ?>">
          </div>

          <div class="col-12">
            <label class="form-label small fw-bold text-secondary">Foto Lapangan (Opsional)</label>
            <input type="file" name="image" class="form-control" accept="image/*">
            <div class="form-text small">Jika tidak diunggah, sistem akan menggunakan ilustrasi standar sesuai cabang olahraga.</div>
          </div>

          <div class="col-12">
            <label class="form-label small fw-bold text-secondary">Deskripsi & Fasilitas Lapangan</label>
            <textarea name="description" class="form-control" rows="3" placeholder="Jelaskan spesifikasi, lampu sorot, tribun, dan fasilitas lapangan..."><?= old('description') ?></textarea>
          </div>
        </div>

        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-sport-primary px-4 py-2">
            <i class="bi bi-save me-1"></i>Simpan Lapangan
          </button>
          <a href="<?= base_url('admin/courts') ?>" class="btn btn-light border px-4 py-2">
            Batal
          </a>
        </div>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
