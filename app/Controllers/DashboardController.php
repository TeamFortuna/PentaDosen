<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ActivityLogModel;

class DashboardController extends Controller
{
    protected $activityLogModel;

    public function __construct()
    {
        helper(['activity']);
        $this->activityLogModel = new ActivityLogModel();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $userId = session()->get('id');

        // Catat aktivitas login jika belum dicatat
        if (!session()->get('login_activity_logged')) {
            log_activity($userId, 'Login', 'User logged in');
            session()->set('login_activity_logged', true);
        }

        $data = [
            'title' => 'Dashboard',
            'user' => [
                'id' => session()->get('id'),
                'nama' => session()->get('nama'),
                'nidn' => session()->get('nidn'),
                'nip' => session()->get('nip'),
                'inisial' => session()->get('inisial'),
                'jabatan' => session()->get('jabatan'),
                'universitas' => session()->get('universitas'),
                'fakultas' => session()->get('fakultas'),
                'jurusan' => session()->get('jurusan'),
                'email' => session()->get('email'),
                'username' => session()->get('username')
            ],
            'activity_logs' => $this->activityLogModel->getLogsWithUsers(10) // Menggunakan method baru
        ];

        return view('dashboard', $data);
    }
}
