<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class IntersectionDosenHAKI extends Migration
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
            'haki_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'constraint'     => 100,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('dosen_id', 'akundosen', 'id', 'CASCADE', 'CASCADE', 'fk_dosen_id_dosenhaki');
        $this->forge->addForeignKey('haki_id', 'haki', 'id', 'CASCADE', 'CASCADE', 'fk_haki_id_dosenhaki');
        $this->forge->createTable('id_dosen_haki');
    }

    public function down()
    {
        $this->forge->dropForeignKey('id_dosen_haki', 'fk_dosen_id_dosenhaki');
        $this->forge->dropForeignKey('id_dosen_haki', 'fk_haki_id_dosenhaki');
        $this->forge->dropTable('id_dosen_haki');
    }
}
