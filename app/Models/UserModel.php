<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'nama',
        'nidn',
        'nip',
        'inisial',
        'jabatan',
        'universitas',
        'fakultas',
        'jurusan',
        'email',
        'username',
        'password',
        'reset_token',
        'reset_expiry'
    ];

    // Tambahkan ini untuk mengaktifkan timestamps
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (! isset($data['data']['password'])) {
            return $data;
        }

        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        return $data;
    }

    public function getUserByUsernameOrEmail($usernameOrEmail)
    {
        return $this->where('username', $usernameOrEmail)
            ->orWhere('email', $usernameOrEmail)
            ->first();
    }
}
