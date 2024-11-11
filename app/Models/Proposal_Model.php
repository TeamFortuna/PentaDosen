<?php

namespace App\Models;

use CodeIgniter\Model;

class Proposal_Model extends Model
{
    protected $table = 'proposal';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'judul_penelitian',
        'tanggal_proposal',
        'file_proposal',
        'skema',
        'skema_lainnya',
        'biaya_diusulkan',
        'biaya_didanai',
        'sumber_dana',
        'dana_lainnya'
    ];

    // Fungsi untuk menyimpan data proposal dan anggota
    public function simpanProposal($data, $anggota)
    {
        // Simpan data proposal ke tabel 'proposals'
        $this->insert($data);
        $proposal_id = $this->insertID();

        // Simpan data anggota jika ada
        if (!empty($anggota)) {
            $anggotaModel = new \App\Models\Anggota_Model();
            foreach ($anggota as $anggotaData) {
                $anggotaData['proposal_id'] = $proposal_id;
                $anggotaModel->insert($anggotaData);
            }
        }

        return $proposal_id;
    }
}
