<?php

namespace App\Models;

use CodeIgniter\Model;

class RegisterLogin_Model extends Model
{
    protected $table = 'akundosen';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama',
        'nidn',
        'nip',
        'inisial_nama',
        'jabatan_akademik',
        'perguruan_tinggi',
        'fakultas',
        'program_studi',
        'email',
        'username',
        'password',
        'user_type',
        'otp', 
        'otp_expiration',
        'created_at',
        'updated_at',
        'deleted_at'
    ];


    protected $useTimestamps = true; // Mengaktifkan timestamps
}
