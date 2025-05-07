<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Jika belum login, redirect ke login
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        // Perbaikan cara mendapatkan current route
        $currentRoute = service('uri')->getSegment(1) ?: 'dashboard';
        $userRole = session()->get('role');

        // Daftar route yang hanya bisa diakses admin
        $adminOnlyRoutes = ['dashboard']; // Tambahkan route lain jika diperlukan

        // Jika user adalah dosen mencoba mengakses route admin
        if ($userRole === 'dosen' && in_array($currentRoute, $adminOnlyRoutes)) {
            return redirect()->to('/kalender')->with('error', 'Anda tidak memiliki akses ke halaman tersebut');
        }

        // Tambahkan pengecekan lain jika diperlukan
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu melakukan apa-apa setelah request
    }
}
