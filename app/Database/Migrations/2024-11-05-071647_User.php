<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 100,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'inisial_nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'program_studi' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true,
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'user_type' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'otp_expiration' => [
                'type'       => 'DATETIME',
                'null'  => true,
            ],
            'otp' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'  => true,
            ],

        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('akundosen');
    }

    public function down()
    {
        $this->forge->dropTable('akundosen');
    }
}
