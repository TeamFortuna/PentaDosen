<?php

namespace App\Models;

use CodeIgniter\Model;

class HkiModel extends Model
{
    protected $table = 'hki';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'judul',
        'jenis',
        'nomor_permohonan',
        'tanggal_permohonan',
        'tempat_diumumkan',
        'tanggal_diumumkan',
        'nomor_pencatatan',
        'status',
        'pencipta_id',
        'pemegang_id',
        'file_path'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getHkiWithUsers()
    {
        return $this->select('hki.*, 
            pencipta.nama as nama_pencipta, 
            pemegang.nama as nama_pemegang')
            ->join('users as pencipta', 'pencipta.id = hki.pencipta_id')
            ->join('users as pemegang', 'pemegang.id = hki.pemegang_id')
            ->findAll();
    }

    public function getHkiWithUsersByUser($userId)
    {
        // Debug untuk melihat query yang dijalankan
        $query = $this->select('hki.*, pencipta.nama as nama_pencipta, pemegang.nama as nama_pemegang')
            ->join('users as pencipta', 'pencipta.id = hki.pencipta_id')
            ->join('users as pemegang', 'pemegang.id = hki.pemegang_id')
            ->where('hki.pencipta_id', $userId)
            ->orWhere('hki.pemegang_id', $userId);

        // Log query untuk debugging
        log_message('debug', 'HKI Query: ' . $this->getLastQuery());

        return $query->findAll();
    }
}