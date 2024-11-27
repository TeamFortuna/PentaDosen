<?php

namespace App\Models;

use CodeIgniter\Model;

class HAKI_Model extends Model
{
    protected $table = 'haki';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'judul_ciptaan',
        'jenis_ciptaan',
        'nomor_permohonan',
        'tanggal_permohonan',
        'tanggal_diumumkan',
        'tempat_diumumkan',
        'nomor_pencatatan',
        'status_haki',
        'nama_pencipta',
        'nama_pemegang',
        'file_haki',
        'tanggal_upload',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true; // Aktifkan fitur timestamps otomatis

    public function getHakiWithPenciptaAndPemegang()
{
    return $this->select('haki.*, akundosen.*, id_dosen_haki.*, 
                          GROUP_CONCAT(dosen_pencipta.nama_pencipta SEPARATOR ", ") AS nama_pencipta, 
                          GROUP_CONCAT(dosen_pemegang.nama_pemegang SEPARATOR ", ") AS nama_pemegang')
                ->join('id_dosen_haki', 'id_dosen_haki.haki_id = haki.id', 'left')
                ->join('akundosen', 'akundosen.id = id_dosen_haki.dosen_id', 'left')
                ->join('dosen_pencipta', 'dosen_pencipta.haki_id = haki.id', 'left')
                ->join('dosen_pemegang', 'dosen_pemegang.haki_id = haki.id', 'left')
                ->groupBy('haki.id')
                ->findAll();
}

}
