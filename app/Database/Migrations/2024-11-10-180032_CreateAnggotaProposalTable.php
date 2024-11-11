<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAnggotaProposalTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'proposal_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
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
                'constraint' => 100,
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
        $this->forge->addForeignKey('proposal_id', 'proposal', 'id', 'CASCADE', 'CASCADE');
        // Pastikan nama tabel benar
        $this->forge->createTable('anggota_proposals');  // Nama tabel diubah menjadi 'anggota_proposals'
    }


    public function down()
    {
        $this->forge->dropTable('anggota_proposal');
    }
}
