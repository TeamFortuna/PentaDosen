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
        'dana_lainnya',
        'tanggal_upload'
    ];
    protected $useTimestamps = true; // Aktifkan fitur timestamps otomatis

    public function getProposalsWithAnggota()
{
    return $this->select('proposal.*, anggota_proposal.*')
                ->join('anggota_proposal', 'anggota_proposal.proposal_id = proposal.id', 'left')
                ->findAll();
}

    public function getProposalsWithDosenAndAnggota()
{
    return $this->select('proposal.*, akundosen.*, id_dosen_proposal.*, 
                          GROUP_CONCAT(anggota_proposal.nama_anggota SEPARATOR ", ") AS anggota_nama')
                ->join('id_dosen_proposal', 'id_dosen_proposal.proposal_id = proposal.id', 'left')
                ->join('akundosen', 'akundosen.id = id_dosen_proposal.dosen_id', 'left')
                ->join('anggota_proposal', 'anggota_proposal.proposal_id = proposal.id', 'left')
                ->groupBy('proposal.id')
                ->findAll();
}

}
