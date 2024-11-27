<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Publikasi extends Migration
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
            'kategori_kegiatan' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'jenis_publikasi' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'judul_publikasi' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'tanggal_terbit' => [
                'type' => 'DATE',
            ],
            'jumlah_halaman' => [
                'type' => 'INT',
                'constraint' => 255
            ],
            'penerbit' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'isbn' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'penulis_dosen' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'file_publikasi' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'tanggal_upload' => [
                'type' => 'DATE',
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
        $this->forge->createTable('publikasi');
    }

    public function down()
    {
        $this->forge->dropTable('publikasi');
    }
}
