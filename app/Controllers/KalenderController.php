<?php

namespace App\Controllers;
use App\Models\Kalender_Model;
date_default_timezone_set('Asia/Jakarta');

class KalenderController extends BaseController
{

    public function kalender()
    {
        helper('form');
        $kalender_model = new Kalender_Model();
        $jadwal = $kalender_model->findAll(); // Ambil semua data jadwal
        return view('kalender', ['jadwal' => $jadwal]);
    }

    public function addJadwal() {

        $kalender_model = new Kalender_Model();
        $judul_kegiatan = $this->request->getPost('judul_kegiatan');
        $batas_awal = $this->request->getPost('batas_awal');
        $batas_akhir = $this->request->getPost('batas_akhir');

        $result = $kalender_model->save([
            'judul_kegiatan'    => $judul_kegiatan,
            'batas_awal'        => $batas_awal,
            'batas_akhir'       => $batas_akhir,
        ]);

        if ($result) {
            $setMsg = [
                "msgDone" => "Berhasil Menambah Jadwal"
            ];
            session()->setFlashdata($setMsg);
            return redirect()->to(base_url('kalender'));
        }
    }

}
