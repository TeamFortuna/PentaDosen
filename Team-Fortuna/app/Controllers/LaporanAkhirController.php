<?php

namespace App\Controllers;

use App\Models\Kpop_Model;

class LaporanAkhirController extends BaseController
{
    public function laporanAkhir()
    {
        return view('laporan_akhir');
    }

    public function searchKpop()
    {
        $query = $this->request->getVar('query');
        $kpopModel = new Kpop_Model();

        // Menangani pencarian yang tidak kosong
        if (!empty($query)) {
            $result = $kpopModel->like('nama', $query)->findAll(); // Pencarian berdasarkan nama grup
            return $this->response->setJSON($result);
        }

        return $this->response->setJSON([]);
    }
}
