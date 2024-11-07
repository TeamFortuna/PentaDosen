<?php

namespace App\Models;

use CodeIgniter\Model;

class Kalender_Model extends Model
{
    protected $table = 'kalender'; // Sesuaikan dengan nama tabel Anda
    protected $primaryKey = 'id';
    protected $allowedFields = ['judul_kegiatan', 'batas_awal', 'batas_akhir'];

    public function getUserById($userId)
    {
        return $this->where('id', $userId)->first();
    }

    // Jika Anda ingin menggunakan fitur timestamp (created_at, updated_at)
    // protected $useTimestamps = true;
}
