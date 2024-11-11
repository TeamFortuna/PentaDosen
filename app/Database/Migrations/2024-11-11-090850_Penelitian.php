<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Penelitian extends Migration
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
            'judul_penelitian' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'skema' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'skema_lainnya' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'biaya_diusulkan' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'biaya_didanai' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'sumber_dana' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'dana_lainnya' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'tanggal_proposal' => [
                'type' => 'DATE',
            ],
            'file_proposal' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
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
        $this->forge->createTable('proposal');  // Nama tabel diubah menjadi 'proposals'
    }


    public function down()
    {
        $this->forge->dropTable('proposal');
    }
}