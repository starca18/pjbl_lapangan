<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="mb-4">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-1 small">
      <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="<?= base_url('admin/courts') ?>">Lapangan</a></li>
      <li class="breadcrumb-item active" aria-current="page">Edit <?= esc($court['name']) ?></li>
    </ol>
  </nav>
  <h3 class="fw-bold mb-1">Edit Data Lapangan</h3>
  <p class="text-secondary small mb-0">Perbarui informasi tarif, spesifikasi lantai, atau status operasional.</p>
</div>

<div class="row">
  <div class="col-lg-8">
    <div class="card border-0 shadow-sm rounded-3 p-4 bg-white">
      <form action="<?= base_url('admin/courts/update/' . $court['id']) ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="row g-3 mb-3">
          <div class="col-md-4">
            <label class="form-label small fw-bold text-secondary">Kode Lapangan <span class="text-danger">*</span></label>
            <input type="text" name="code" class="form-control text-uppercase font-monospace" required value="<?= esc(old('code', $court['code'])) ?>">
          </div>

          <div class="col-md-8">
            <label class="form-label small fw-bold text-secondary">Nama Lapangan <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" required value="<?= esc(old('name', $court['name'])) ?>">
          </div>

          <div class="col-md-6">
            <label class="form-label small fw-bold text-secondary">Cabang Olahraga <span class="text-danger">*</span></label>
            <select name="category_id" class="form-select" required>
              <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>" <?= (old('category_id', $court['category_id']) == $cat['id']) ? 'selected' : '' ?>>
                  <?= esc($cat['name']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label small fw-bold text-secondary">Tipe Venue <span class="text-danger">*</span></label>
            <select name="court_type" class="form-select">
              <option value="Indoor" <?= old('court_type', $court['court_type']) === 'Indoor' ? 'selected' : '' ?>>Indoor (Dalam Ruangan)</option>
              <option value="Outdoor" <?= old('court_type', $court['court_type']) === 'Outdoor' ? 'selected' : '' ?>>Outdoor (Luar Ruangan)</option>
              <option value="Semi-Indoor" <?= old('court_type', $court['court_type']) === 'Semi-Indoor' ? 'selected' : '' ?>>Semi-Indoor (Atap Canopy)</option>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label small fw-bold text-secondary">Jenis Permukaan Lantai</label>
            <input type="text" name="floor_type" class="form-control" value="<?= esc(old('floor_type', $court['floor_type'] ?? '')) ?>">
          </div>

          <div class="col-md-6">
            <label class="form-label small fw-bold text-secondary">Tarif Sewa per Jam (Rp) <span class="text-danger">*</span></label>
            <input type="number" step="1000" name="price_per_hour" class="form-control" required value="<?= esc(old('price_per_hour', $court['price_per_hour'])) ?>">
          </div>

          <div class="col-12">
            <label class="form-label small fw-bold text-secondary">Foto Lapangan (Biarkan kosong jika tidak diganti)</label>
            <div class="d-flex align-items-center gap-3 mb-2">
              <div style="width:60px;height:40px;" class="rounded overflow-hidden bg-dark">
                <img src="<?= base_url('assets/images/courts/' . esc($court['image'])) ?>" alt="" style="width:100%;height:100%;object-fit:cover;">
              </div>
              <input type="file" name="image" class="form-control" accept="image/*">
            </div>
          </div>

          <div class="col-12">
            <label class="form-label small fw-bold text-secondary">Deskripsi & Fasilitas Lapangan</label>
            <textarea name="description" class="form-control" rows="3"><?= esc(old('description', $court['description'] ?? '')) ?></textarea>
          </div>

          <div class="col-12">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" name="is_active" value="1" id="activeSwitch" <?= $court['is_active'] ? 'checked' : '' ?>>
              <label class="form-check-label fw-bold small text-secondary" for="activeSwitch">
                Lapangan Aktif & Siap Disewa (Centang jika aktif, matikan untuk perawatan/maintenance)
              </label>
            </div>
          </div>
        </div>

        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-sport-primary px-4 py-2">
            <i class="bi bi-save me-1"></i>Simpan Perubahan
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
