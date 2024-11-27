<?php

namespace App\Models;

use CodeIgniter\Model;

class Intersection_Dosen_Proposal extends Model
{
    protected $table = 'id_dosen_penelitian';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'dosen_id',
        'penelitian_id',
    ];

}
