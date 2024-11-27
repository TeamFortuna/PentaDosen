<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class NamaPencipta extends Migration
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
            'nama_pencipta' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'nidn_pencipta' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'jabatan_pencipta' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'perguruan_pencipta' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'perguruan_lainnya' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'fakultas_pencipta' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'fakultas_lainnya' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'prodi_pencipta' => [
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
        $this->forge->addForeignKey('haki_id', 'haki', 'id', 'CASCADE', 'CASCADE', 'fk_haki_id_penciptahaki');
        // Pastikan nama tabel benar
        $this->forge->createTable('dosen_pencipta');  // Nama tabel diubah menjadi 'dosen_penulis'
    }

    public function down()
    {
        $this->forge->dropForeignKey('dosen_pencipta', 'fk_haki_id_penciptahaki');
        $this->forge->dropTable('dosen_pencipta');

    }
}
