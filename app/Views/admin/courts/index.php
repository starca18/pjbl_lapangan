<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
  <div>
    <h3 class="fw-bold mb-1">Manajemen Lapangan</h3>
    <p class="text-secondary small mb-0">Kelola master lapangan futsal, mini soccer, badminton, voli, tenis, dan padel.</p>
  </div>
  <a href="<?= base_url('admin/courts/create') ?>" class="btn btn-sport-primary btn-sm">
    <i class="bi bi-plus-lg me-1"></i>Tambah Lapangan Baru
  </a>
</div>

<!-- Category Filter -->
<div class="d-flex flex-wrap gap-2 mb-4">
  <a href="<?= base_url('admin/courts') ?>" class="btn btn-sm rounded-pill <?= empty($selectedCategory) ? 'btn-sport-primary' : 'btn-outline-secondary' ?>">
    Semua Olahraga
  </a>
  <?php foreach ($categories as $cat): ?>
    <a href="<?= base_url('admin/courts?category=' . $cat['id']) ?>" class="btn btn-sm rounded-pill <?= $selectedCategory == $cat['id'] ? 'btn-sport-primary' : 'btn-outline-secondary' ?>">
      <?= esc($cat['name']) ?>
    </a>
  <?php endforeach; ?>
</div>

<div class="card border-0 shadow-sm rounded-3 bg-white overflow-hidden">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light small text-secondary">
        <tr>
          <th class="ps-3">KODE / FOTO</th>
          <th>NAMA LAPANGAN</th>
          <th>CABANG OLAHRAGA</th>
          <th>TIPE & LANTAI</th>
          <th>TARIF / JAM</th>
          <th>STATUS</th>
          <th class="text-end pe-3">AKSI</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($courts)): ?>
          <tr>
            <td colspan="7" class="text-center py-5 text-muted">Belum ada data lapangan.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($courts as $court): ?>
            <tr>
              <td class="ps-3">
                <div class="d-flex align-items-center gap-2">
                  <div style="width:48px;height:48px;flex-shrink:0;" class="rounded overflow-hidden bg-dark">
                    <img src="<?= base_url('assets/images/courts/' . esc($court['image'])) ?>" alt="" style="width:100%;height:100%;object-fit:cover;">
                  </div>
                  <span class="badge bg-secondary-subtle text-secondary font-monospace"><?= esc($court['code']) ?></span>
                </div>
              </td>

              <td>
                <div class="fw-bold text-dark"><?= esc($court['name']) ?></div>
                <div class="text-muted small text-truncate" style="max-width:250px;"><?= esc($court['description']) ?></div>
              </td>

              <td>
                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                  <?= esc($court['category_name']) ?>
                </span>
              </td>

              <td>
                <div><span class="badge bg-light text-dark border"><?= esc($court['court_type']) ?></span></div>
                <div class="small text-muted mt-0.5"><?= esc($court['floor_type'] ?? '-') ?></div>
              </td>

              <td class="fw-bold text-success">
                <?= rupiah($court['price_per_hour']) ?>
              </td>

              <td>
                <?php if ($court['is_active']): ?>
                  <span class="badge bg-success text-white px-2 py-1">Aktif</span>
                <?php else: ?>
                  <span class="badge bg-danger text-white px-2 py-1">Maintenance</span>
                <?php endif; ?>
              </td>

              <td class="text-end pe-3">
                <div class="d-inline-flex align-items-center gap-1">
                  <form action="<?= base_url('admin/courts/toggle/' . $court['id']) ?>" method="post" class="d-inline m-0">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-sm btn-outline-secondary" title="<?= $court['is_active'] ? 'Set Maintenance' : 'Aktifkan' ?>">
                      <i class="bi <?= $court['is_active'] ? 'bi-toggle-on text-success' : 'bi-toggle-off text-muted' ?>"></i>
                    </button>
                  </form>
                  <a href="<?= base_url('admin/courts/edit/' . $court['id']) ?>" class="btn btn-sm btn-outline-secondary" title="Edit">
                    <i class="bi bi-pencil"></i>
                  </a>
                  <form action="<?= base_url('admin/courts/delete/' . $court['id']) ?>" method="post" class="d-inline m-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lapangan ini?')">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?= $this->endSection() ?>
