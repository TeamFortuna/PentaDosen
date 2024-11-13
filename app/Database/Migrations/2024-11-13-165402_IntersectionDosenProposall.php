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
            'proposal_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'constraint'     => 100,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('dosen_id', 'akundosen', 'id', 'CASCADE', 'CASCADE', 'fk_dosen_id_dosenproposal');
        $this->forge->addForeignKey('proposal_id', 'proposal', 'id', 'CASCADE', 'CASCADE', 'fk_proposal_id_dosenproposal');
        $this->forge->createTable('id_dosen_proposal');
    }


    public function down()
    {
        $this->forge->dropForeignKey('id_dosen_proposal', 'fk_dosen_id_dosenproposal');
        $this->forge->dropForeignKey('id_dosen_proposal', 'fk_proposal_id_dosenproposal');
        $this->forge->dropTable('id_dosen_proposal');
    }
}
