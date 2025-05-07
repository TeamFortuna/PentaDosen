<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePenulisPublikasiTable extends Migration
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
            'publikasi_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true, // Tambahkan ini
            ],
            'dosen_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true, // Tambahkan ini jika users.id juga UNSIGNED
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);

        // Tambahkan foreign key dengan tipe yang sesuai
        $this->forge->addForeignKey('publikasi_id', 'publikasi', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('dosen_id', 'users', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('penulis_publikasi');
    }

    public function down()
    {
        $this->forge->dropTable('penulis_publikasi');
    }
}
