<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('is_logged_in')) {
            return redirect()->to(base_url('admin/dashboard'));
        }

        return view('auth/login', [
            'title' => 'Masuk Administrator - ArenaSport',
        ]);
    }

    public function processLogin()
    {
        $username = trim($this->request->getPost('username') ?? '');
        $password = $this->request->getPost('password') ?? '';

        if (empty($username) || empty($password)) {
            return redirect()->back()->withInput()->with('error', 'Username dan password wajib diisi.');
        }

        $userModel = new UserModel();
        $user = $userModel->findByUsername($username);

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Username atau kata sandi tidak valid.');
        }

        // Set session
        session()->set([
            'user_id'      => $user['id'],
            'username'     => $user['username'],
            'full_name'    => $user['full_name'],
            'role'         => $user['role'],
            'is_logged_in' => true,
        ]);

        return redirect()->to(base_url('admin/dashboard'))->with('success', 'Selamat datang kembali, ' . esc($user['full_name']) . '!');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'))->with('success', 'Anda telah berhasil keluar.');
    }
}
