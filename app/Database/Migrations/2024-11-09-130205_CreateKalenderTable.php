<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKalenderTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'judul_kegiatan' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
            ],
            'batas_awal' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'batas_akhir' => [
                'type' => 'DATE',
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
        $this->forge->createTable('kalender');
    }

    public function down()
    {
        $this->forge->dropTable('kalender');
    }
}
