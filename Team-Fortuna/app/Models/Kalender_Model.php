<?php

namespace App\Models;

use CodeIgniter\Model;

class Kalender_Model extends Model
{
    protected $table = 'kalender'; // Sesuaikan dengan nama tabel Anda
    protected $primaryKey = 'id';
    protected $allowedFields = ['judul_kegiatan', 'deskripsi', 'batas_awal', 'batas_akhir', 'created_at', 'updated_at'];
    protected $useTimestamps = true; // Aktifkan fitur timestamps otomatis


    public function getUserById($userId)
    {
        return $this->where('id', $userId)->first();
    }
}
