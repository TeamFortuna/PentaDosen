<?php

namespace App\Models;

use CodeIgniter\Model;

class PenelitianModel extends Model
{
    protected $table = 'penelitian';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = [
        'judul',
        'ketua_id',
        'skema',
        'sumber_dana',
        'biaya_diusulkan',
        'biaya_didanai',
        'status',
        'tanggal',
        'file_proposal',
        'file_laporan_kemajuan',
        'file_laporan_akhir'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'judul' => 'required',
        'ketua_id' => 'required|numeric',
        'skema' => 'required',
        'sumber_dana' => 'required',
        'biaya_diusulkan' => 'required|numeric',
        'biaya_didanai' => 'required|numeric',
        'status' => 'required',
        'tanggal' => 'required|valid_date'
    ];
} 