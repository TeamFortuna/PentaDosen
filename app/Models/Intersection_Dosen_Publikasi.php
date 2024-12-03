<?php

namespace App\Models;

use CodeIgniter\Model;

class Intersection_Dosen_Publikasi extends Model
{
    protected $table = 'id_dosen_publikasi';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'dosen_id',
        'publikasi_id',
    ];

}
