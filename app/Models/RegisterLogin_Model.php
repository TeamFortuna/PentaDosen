<?php

namespace App\Models;

use CodeIgniter\Model;

class RegisterLogin_Model extends Model
{
    protected $table = 'dosen'; // Sesuaikan dengan nama tabel Anda
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama', 'inisial_nama', 'program_studi', 'email', 'username', 'password', 'user_type'];
    

    // Jika Anda ingin menggunakan fitur timestamp (created_at, updated_at)
    // protected $useTimestamps = true;
}
