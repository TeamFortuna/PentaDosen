<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivityLogModel extends Model
{
    protected $table = 'activity_logs';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'activity', 'description', 'ip_address', 'user_agent'];
    protected $useTimestamps = true;

    // Untuk menampilkan log dengan nama user
    public function getLogsWithUsers($limit = 10)
    {
        return $this->select('activity_logs.*, users.nama as user_name')
            ->join('users', 'users.id = activity_logs.user_id')
            ->orderBy('activity_logs.created_at', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    // Untuk log user tertentu saja
    public function getLogsByUserId($userId, $limit = 10)
    {
        return $this->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->findAll();
    }
}
