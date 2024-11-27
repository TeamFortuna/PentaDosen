<?php

namespace App\Models;

use CodeIgniter\Model;

class Dosen_Pencipta_Model extends Model
{
    protected $table = 'dosen_pencipta';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'haki_id',
        'nama_pencipta',
        'nidn_pencipta',
        'jabatan_pencipta',
        'perguruan_pencipta',
        'perguruan_lainnya',
        'fakultas_pencipta',
        'fakultas_lainnya',
        'prodi_pencipta',
        'prodi_lainnya',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true; // Aktifkan fitur timestamps otomatis

    
}
