<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePenelitianTable extends Migration
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
            'ketua_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'skema' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'sumber_dana' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'biaya_diusulkan' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'biaya_didanai' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'default' => 'draft',
            ],
            'tanggal' => [
                'type' => 'DATE',
            ],
            'file_proposal' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'file_laporan_kemajuan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'file_laporan_akhir' => [
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
        $this->forge->addForeignKey('ketua_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('penelitian');
    }

    public function down()
    {
        $this->forge->dropTable('penelitian');
    }
} 