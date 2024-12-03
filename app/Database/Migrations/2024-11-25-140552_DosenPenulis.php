<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DosenPenulis extends Migration
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
            'publikasi_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'constraint'     => 100,
            ],
            'nama_penulis' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'nidn_penulis' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'jabatan_penulis' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'perguruan_penulis' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'perguruan_lainnya' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'fakultas_penulis' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'fakultas_lainnya' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'prodi_penulis' => [
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
        $this->forge->addForeignKey('publikasi_id', 'publikasi', 'id', 'CASCADE', 'CASCADE', 'fk_publikasi_id');
        // Pastikan nama tabel benar
        $this->forge->createTable('dosen_penulis');  // Nama tabel diubah menjadi 'dosen_penulis'
    }

    public function down()
    {
        $this->forge->dropForeignKey('dosen_penulis', 'fk_publikasi_id');
        $this->forge->dropTable('dosen_penulis');

    }
}
