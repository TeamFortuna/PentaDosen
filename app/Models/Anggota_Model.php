<?php

namespace App\Models;

use CodeIgniter\Model;

class Anggota_Model extends Model
{
    protected $table = 'anggota_penelitian';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'penelitian_id',
        'nama_anggota',
        'nidn_anggota',
        'jabatan_anggota',
        'perguruan_anggota',
        'perguruan_lainnya',
        'fakultas_anggota',
        'fakultas_lainnya',
        'prodi_anggota',
        'prodi_lainnya'
    ];
    protected $useTimestamps = true; // Aktifkan fitur timestamps otomatis

    
}
