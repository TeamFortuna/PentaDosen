<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAnggotaPenelitianTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'penelitian_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'nidn' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'jabatan' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'universitas' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'fakultas' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'jurusan' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'tipe' => [
                'type' => 'ENUM',
                'constraint' => ['internal', 'eksternal'],
                'default' => 'internal',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('penelitian_id', 'penelitian', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('anggota_penelitian');
    }

    public function down()
    {
        $this->forge->dropTable('anggota_penelitian');
    }
} 