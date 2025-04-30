<?php

namespace App\Models;

use CodeIgniter\Model;

class EventModel extends Model
{
    protected $table = 'events';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'title',
        'description',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'color',
        'event_type',
        'user_id'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getEventsByUserId($userId)
    {
        return $this->where('user_id', $userId)->findAll();
    }
} 