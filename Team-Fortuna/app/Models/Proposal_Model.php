<?php

namespace App\Models;

use CodeIgniter\Model;

class Proposal_Model extends Model
{
    protected $table = 'penelitian';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'judul_penelitian',
        'tanggal_penelitian',
        'file_penelitian',
        'skema',
        'skema_lainnya',
        'biaya_diusulkan',
        'biaya_didanai',
        'sumber_dana',
        'dana_lainnya',
        'tanggal_upload'
    ];
    protected $useTimestamps = true; // Aktifkan fitur timestamps otomatis

    public function getPenelitianWithAnggota()
{
    return $this->select('penelitian.*, anggota_penelitian.*')
                ->join('anggota_penelitian', 'anggota_penelitian.penelitian_id = penelitian.id', 'left')
                ->findAll();
}

    public function getPenelitianWithDosenAndAnggota()
{
    return $this->select('penelitian.*, akundosen.*, id_dosen_penelitian.*, 
                          GROUP_CONCAT(anggota_penelitian.nama_anggota SEPARATOR ", ") AS anggota_nama')
                ->join('id_dosen_penelitian', 'id_dosen_penelitian.penelitian_id = penelitian.id', 'left')
                ->join('akundosen', 'akundosen.id = id_dosen_penelitian.dosen_id', 'left')
                ->join('anggota_penelitian', 'anggota_penelitian.penelitian_id = penelitian.id', 'left')
                ->groupBy('penelitian.id')
                ->findAll();
}

}
