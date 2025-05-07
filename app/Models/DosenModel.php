<?php

namespace App\Models;

use CodeIgniter\Model;

class DosenModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama', 'nidn', 'nip', 'role'];

    public function getAllDosen()
    {
        return $this->where('role', 'dosen')->findAll();
    }
}
