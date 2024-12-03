<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class NamaPemegang extends Migration
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
            'haki_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'constraint'     => 100,
            ],
            'nama_pemegang' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'nidn_pemegang' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'jabatan_pemegang' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'perguruan_pemegang' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'perguruan_lainnya' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'fakultas_pemegang' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'fakultas_lainnya' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'prodi_pemegang' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'prodi_lainnya' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
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
        $this->forge->addForeignKey('haki_id', 'haki', 'id', 'CASCADE', 'CASCADE', 'fk_haki_id_pemeganghaki');
        // Pastikan nama tabel benar
        $this->forge->createTable('dosen_pemegang');  // Nama tabel diubah menjadi 'dosen_penulis'
    }

    public function down()
    {
        $this->forge->dropForeignKey('dosen_pemegang', 'fk_haki_id_pemeganghaki');
        $this->forge->dropTable('dosen_pemegang');
    }
}
