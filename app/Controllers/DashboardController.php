<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Cek apakah user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Dashboard',
            'user' => [
                'nama' => session()->get('nama'),
                'jabatan' => session()->get('jabatan'),
                'universitas' => session()->get('universitas'),
                'fakultas' => session()->get('fakultas'),
                'jurusan' => session()->get('jurusan')
            ]
        ];

        return view('dashboard', $data);
    }
}
