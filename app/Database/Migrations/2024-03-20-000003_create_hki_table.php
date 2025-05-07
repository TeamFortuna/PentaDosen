<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateHkiTable extends Migration
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
            'judul' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'jenis' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'nomor_permohonan' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'tanggal_permohonan' => [
                'type' => 'DATE',
            ],
            'tempat_diumumkan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'tanggal_diumumkan' => [
                'type' => 'DATE',
            ],
            'nomor_pencatatan' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'pencipta_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'pemegang_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'file_path' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
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
        $this->forge->addForeignKey('pencipta_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('pemegang_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('hki');
    }

    public function down()
    {
        $this->forge->dropTable('hki');
    }
} 