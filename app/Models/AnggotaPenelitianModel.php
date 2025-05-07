<?php

namespace App\Models;

use CodeIgniter\Model;

class AnggotaPenelitianModel extends Model
{
    protected $table = 'anggota_penelitian';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = [
        'penelitian_id',
        'user_id',
        'nama',
        'nidn',
        'jabatan',
        'universitas',
        'fakultas',
        'jurusan',
        'tipe' // 'internal' atau 'eksternal'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'penelitian_id' => 'required|numeric',
        'nama' => 'required',
        'nidn' => 'required',
        'jabatan' => 'required',
        'universitas' => 'required',
        'fakultas' => 'required',
        'jurusan' => 'required',
        'tipe' => 'required|in_list[internal,eksternal]'
    ];
} 