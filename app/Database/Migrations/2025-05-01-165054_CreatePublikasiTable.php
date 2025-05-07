<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePublikasiTable extends Migration
{
    public function up()
    {
        // Tabel publikasi
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
            'kategori' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'jenis' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'tanggal_terbit' => [
                'type' => 'DATE',
            ],
            'jumlah_halaman' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'penerbit' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'isbn' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'file_path' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'file_size' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
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
        $this->forge->addForeignKey('created_by', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('publikasi');

        // Tabel relasi publikasi_penulis
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
                'unsigned' => true,
            ],
            'dosen_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('publikasi_id', 'publikasi', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('dosen_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('publikasi_penulis');
    }

    public function down()
    {
        $this->forge->dropTable('publikasi_penulis');
        $this->forge->dropTable('publikasi');
    }
}
