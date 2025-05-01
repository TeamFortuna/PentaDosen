<?php

namespace App\Models;

use CodeIgniter\Model;

class EventModel extends Model
{
    protected $table = 'events';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'description', 'start_date', 'end_date', 'color', 'class_name', 'user_id'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getEvents($userId, $start, $end)
    {
        return $this->where('user_id', $userId)
            ->where('start_date >=', $start)
            ->where('start_date <=', $end)
            ->orWhere('end_date >=', $start)
            ->where('end_date <=', $end)
            ->findAll();
    }
}
