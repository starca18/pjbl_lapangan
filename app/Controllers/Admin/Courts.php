<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\CourtModel;
use App\Models\BookingModel;

class Courts extends BaseController
{
    public function index()
    {
        $courtModel    = new CourtModel();
        $categoryModel = new CategoryModel();

        $selectedCategory = $this->request->getGet('category');
        $courts = $courtModel->getCourtsWithCategory($selectedCategory ? (int) $selectedCategory : null, false);
        $categories = $categoryModel->findAll();

        return view('admin/courts/index', [
            'title'            => 'Manajemen Lapangan - Admin',
            'courts'           => $courts,
            'categories'       => $categories,
            'selectedCategory' => $selectedCategory,
        ]);
    }

    public function create()
    {
        $categoryModel = new CategoryModel();
        return view('admin/courts/create', [
            'title'      => 'Tambah Lapangan Baru - Admin',
            'categories' => $categoryModel->findAll(),
        ]);
    }

    public function store()
    {
        $courtModel = new CourtModel();

        $code        = strtoupper(trim($this->request->getPost('code') ?? ''));
        $name        = trim($this->request->getPost('name') ?? '');
        $categoryId  = (int) $this->request->getPost('category_id');
        $courtType   = $this->request->getPost('court_type') ?: 'Indoor';
        $floorType   = trim($this->request->getPost('floor_type') ?? '');
        $price       = (float) $this->request->getPost('price_per_hour');
        $description = trim($this->request->getPost('description') ?? '');

        if (empty($code) || empty($name) || !$categoryId || $price <= 0) {
            return redirect()->back()->withInput()->with('error', 'Harap isi semua kolom wajib dengan benar.');
        }

        // Check unique code
        if ($courtModel->where('code', $code)->first()) {
            return redirect()->back()->withInput()->with('error', 'Kode lapangan sudah digunakan.');
        }

        // Default image by category
        $defaultImages = [
            1 => 'futsal_vinyl.svg',
            2 => 'minisoccer.svg',
            3 => 'badminton_1.svg',
            4 => 'voli.svg',
            5 => 'tenis.svg',
            6 => 'padel_indoor.svg',
        ];
        $imageName = $defaultImages[$categoryId] ?? 'futsal_vinyl.svg';

        $imgFile = $this->request->getFile('image');
        if ($imgFile && $imgFile->isValid() && !$imgFile->hasMoved()) {
            $validationRule = [
                'image' => [
                    'label' => 'Gambar Lapangan',
                    'rules' => 'uploaded[image]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]|max_size[image,2048]',
                ],
            ];
            if (! $this->validate($validationRule)) {
                return redirect()->back()->withInput()->with('error', 'Format gambar tidak valid. Gunakan file JPG, PNG, atau WEBP dengan ukuran maksimal 2MB.');
            }
            $newName = $imgFile->getRandomName();
            $imgFile->move(FCPATH . 'assets/images/courts', $newName);
            $imageName = $newName;
        }

        $courtModel->insert([
            'category_id'    => $categoryId,
            'code'           => $code,
            'name'           => $name,
            'court_type'     => $courtType,
            'floor_type'     => $floorType,
            'price_per_hour' => $price,
            'image'          => $imageName,
            'description'    => $description,
            'is_active'      => 1,
        ]);

        return redirect()->to(base_url('admin/courts'))->with('success', 'Lapangan baru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $courtModel    = new CourtModel();
        $categoryModel = new CategoryModel();

        $court = $courtModel->find($id);
        if (!$court) {
            return redirect()->to(base_url('admin/courts'))->with('error', 'Lapangan tidak ditemukan.');
        }

        return view('admin/courts/edit', [
            'title'      => 'Edit Lapangan ' . $court['name'] . ' - Admin',
            'court'      => $court,
            'categories' => $categoryModel->findAll(),
        ]);
    }

    public function update($id)
    {
        $courtModel = new CourtModel();
        $court = $courtModel->find($id);

        if (!$court) {
            return redirect()->to(base_url('admin/courts'))->with('error', 'Lapangan tidak ditemukan.');
        }

        $code        = strtoupper(trim($this->request->getPost('code') ?? ''));
        $name        = trim($this->request->getPost('name') ?? '');
        $categoryId  = (int) $this->request->getPost('category_id');
        $courtType   = $this->request->getPost('court_type') ?: 'Indoor';
        $floorType   = trim($this->request->getPost('floor_type') ?? '');
        $price       = (float) $this->request->getPost('price_per_hour');
        $description = trim($this->request->getPost('description') ?? '');
        $isActive    = $this->request->getPost('is_active') ? 1 : 0;

        if (empty($code) || empty($name) || !$categoryId || $price <= 0) {
            return redirect()->back()->withInput()->with('error', 'Harap isi semua kolom wajib dengan benar.');
        }

        // Check unique code if changed
        $existing = $courtModel->where('code', $code)->where('id !=', $id)->first();
        if ($existing) {
            return redirect()->back()->withInput()->with('error', 'Kode lapangan sudah digunakan oleh lapangan lain.');
        }

        $imageName = $court['image'];
        $imgFile = $this->request->getFile('image');
        if ($imgFile && $imgFile->isValid() && !$imgFile->hasMoved()) {
            $validationRule = [
                'image' => [
                    'label' => 'Gambar Lapangan',
                    'rules' => 'uploaded[image]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]|max_size[image,2048]',
                ],
            ];
            if (! $this->validate($validationRule)) {
                return redirect()->back()->withInput()->with('error', 'Format gambar tidak valid. Gunakan file JPG, PNG, atau WEBP dengan ukuran maksimal 2MB.');
            }
            $newName = $imgFile->getRandomName();
            $imgFile->move(FCPATH . 'assets/images/courts', $newName);
            $imageName = $newName;
        }

        $courtModel->update($id, [
            'category_id'    => $categoryId,
            'code'           => $code,
            'name'           => $name,
            'court_type'     => $courtType,
            'floor_type'     => $floorType,
            'price_per_hour' => $price,
            'image'          => $imageName,
            'description'    => $description,
            'is_active'      => $isActive,
        ]);

        return redirect()->to(base_url('admin/courts'))->with('success', 'Data lapangan berhasil diperbarui.');
    }

    public function toggleStatus($id)
    {
        $courtModel = new CourtModel();
        $court = $courtModel->find($id);

        if ($court) {
            $newStatus = $court['is_active'] ? 0 : 1;
            $courtModel->update($id, ['is_active' => $newStatus]);
            $msg = $newStatus ? 'Lapangan diaktifkan.' : 'Lapangan dinonaktifkan (maintenance).';
            return redirect()->back()->with('success', $msg);
        }

        return redirect()->back()->with('error', 'Lapangan tidak ditemukan.');
    }

    public function delete($id)
    {
        $courtModel   = new CourtModel();
        $bookingModel = new BookingModel();

        // Check if there are active bookings
        $hasActiveBookings = $bookingModel->where('court_id', $id)
                                         ->where('booking_date >=', date('Y-m-d'))
                                         ->whereIn('status', ['confirmed', 'pending'])
                                         ->first();

        if ($hasActiveBookings) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus lapangan karena masih ada reservasi aktif terjadwal.');
        }

        $courtModel->delete($id);
        return redirect()->to(base_url('admin/courts'))->with('success', 'Lapangan berhasil dihapus.');
    }
}
