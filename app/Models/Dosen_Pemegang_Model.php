<?php

namespace App\Models;

use CodeIgniter\Model;

class Dosen_Pemegang_Model extends Model
{
    protected $table = 'dosen_pemegang';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'haki_id',
        'nama_pemegang',
        'nidn_pemegang',
        'jabatan_pemegang',
        'perguruan_pemegang',
        'perguruan_lainnya',
        'fakultas_pemegang',
        'fakultas_lainnya',
        'prodi_pemegang',
        'prodi_lainnya',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true; // Aktifkan fitur timestamps otomatis

    
}
