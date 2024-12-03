<?php

namespace App\Models;

use CodeIgniter\Model;

class Intersection_Dosen_HAKI extends Model
{
    protected $table = 'id_dosen_haki';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'dosen_id',
        'haki_id',
    ];

}
