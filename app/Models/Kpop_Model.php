<?php

namespace App\Models;

use CodeIgniter\Model;

class Kpop_Model extends Model
{
    protected $table = 'kpop';       // Nama tabel di database
    protected $primaryKey = 'id';    // Kolom primary key
    protected $allowedFields = ['nama'];  // Kolom yang boleh diinsert atau diupdate
}
