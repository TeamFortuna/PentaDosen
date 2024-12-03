<?php

namespace App\Models;

use CodeIgniter\Model;

class Dosen_Penulis_Model extends Model
{
    protected $table = 'dosen_penulis';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'publikasi_id',
        'nama_penulis',
        'nidn_penulis',
        'jabatan_penulis',
        'perguruan_penulis',
        'perguruan_lainnya',
        'fakultas_penulis',
        'fakultas_lainnya',
        'prodi_penulis',
        'prodi_lainnya'
    ];
    protected $useTimestamps = true; // Aktifkan fitur timestamps otomatis

    
}
