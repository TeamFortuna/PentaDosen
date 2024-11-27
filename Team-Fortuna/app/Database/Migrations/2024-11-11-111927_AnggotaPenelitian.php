<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use PHPUnit\Framework\Constraint\Constraint;

class AnggotaPenelitian extends Migration
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
            'penelitian_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'constraint'     => 100,
            ],
            'nama_anggota' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'nidn_anggota' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'jabatan_anggota' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'perguruan_anggota' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'perguruan_lainnya' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'fakultas_anggota' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'fakultas_lainnya' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'prodi_anggota' => [
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
        $this->forge->addForeignKey('penelitian_id', 'penelitian', 'id', 'CASCADE', 'CASCADE', 'fk_penelitian_id');
        // Pastikan nama tabel benar
        $this->forge->createTable('anggota_penelitian');  // Nama tabel diubah menjadi 'anggota_penelitians'
    }


    public function down()
    {
        $this->forge->dropForeignKey('anggota_penelitian', 'fk_penelitian_id');
        $this->forge->dropTable('anggota_penelitian');
    }
}
