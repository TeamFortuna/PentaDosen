<?php

namespace App\Models;

use CodeIgniter\Model;

class Proposal_Model extends Model
{
    protected $table = 'proposal';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'judul_penelitian',
        'tanggal_proposal',
        'file_proposal',
        'skema',
        'skema_lainnya',
        'biaya_diusulkan',
        'biaya_didanai',
        'sumber_dana',
        'dana_lainnya',
        'tanggal_upload'
    ];

}
