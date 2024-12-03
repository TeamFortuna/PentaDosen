<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class IntersectionDosenProposal extends Migration
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
            'dosen_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'constraint'     => 100,
            ],
            'penelitian_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'constraint'     => 100,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('dosen_id', 'akundosen', 'id', 'CASCADE', 'CASCADE', 'fk_dosen_id_dosenpenelitian');
        $this->forge->addForeignKey('penelitian_id', 'penelitian', 'id', 'CASCADE', 'CASCADE', 'fk_penelitian_id_dosenpenelitian');
        $this->forge->createTable('id_dosen_penelitian');
    }


    public function down()
    {
        $this->forge->dropForeignKey('id_dosen_penelitian', 'fk_dosen_id_dosenpenelitian');
        $this->forge->dropForeignKey('id_dosen_penelitian', 'fk_penelitian_id_dosenpenelitian');
        $this->forge->dropTable('id_dosen_penelitian');
    }
}
