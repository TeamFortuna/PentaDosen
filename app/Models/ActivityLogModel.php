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
        return $this->select('activity_logs.*, users.nama as user_name, users.fakultas as user_fakultas, users.jurusan as user_jurusan')
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

    public function getFilteredLogs($filters = [], $limit = 10)
    {
        $builder = $this->select('activity_logs.*, users.nama as user_name, users.fakultas as user_fakultas, users.jurusan as user_jurusan')
            ->join('users', 'users.id = activity_logs.user_id');

        if (!empty($filters['activity'])) {
            $builder->where('activity', $filters['activity']);
        }

        if (!empty($filters['search'])) {
            $builder->groupStart()
                ->like('activity', $filters['search'])
                ->orLike('description', $filters['search'])
                ->orLike('users.nama', $filters['search'])
                ->groupEnd();
        }

        if (!empty($filters['fakultas'])) {
            $builder->where('users.fakultas', $filters['fakultas']);
        }

        if (!empty($filters['jurusan'])) {
            $builder->where('users.jurusan', $filters['jurusan']);
        }

        return $builder->orderBy('activity_logs.created_at', 'DESC')
            ->limit($limit)
            ->findAll();
    }
}
