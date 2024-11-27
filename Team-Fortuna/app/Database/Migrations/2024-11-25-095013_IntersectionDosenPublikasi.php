<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class IntersectionDosenPublikasi extends Migration
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
            'publikasi_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'constraint'     => 100,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('dosen_id', 'akundosen', 'id', 'CASCADE', 'CASCADE', 'fk_dosen_id_dosenpublikasi');
        $this->forge->addForeignKey('publikasi_id', 'publikasi', 'id', 'CASCADE', 'CASCADE', 'fk_publikasi_id_dosenpublikasi');
        $this->forge->createTable('id_dosen_publikasi');
    }

    public function down()
    {
        $this->forge->dropForeignKey('id_dosen_publikasi', 'fk_dosen_id_dosenpublikasi');
        $this->forge->dropForeignKey('id_dosen_publikasi', 'fk_publikasi_id_dosenpublikasi');
        $this->forge->dropTable('id_dosen_publikasi');
    }
}
