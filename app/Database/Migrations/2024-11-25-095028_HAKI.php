<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class HAKI extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 100,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'judul_ciptaan' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'jenis_ciptaan' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'nomor_permohonan' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'tanggal_permohonan' => [
                'type' => 'DATE',
            ],
            'tanggal_diumumkan' => [
                'type' => 'DATE',
            ],
            'tempat_diumumkan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'nomor_pencatatan' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'status_haki' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'nama_pencipta' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'nama_pemegang' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'file_haki' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'tanggal_upload' => [
                'type' => 'DATE',
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('haki');
    }

    public function down()
    {
        $this->forge->dropTable('haki');
    }
}
