<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class JadwalKonsultasi extends Migration
{
public function up()
    {
        $this->forge->addField([
            'id_jadwal' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_dosen' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'tanggal' => [
                'type' => 'DATE',
            ],
            'jam_mulai' => [
                'type' => 'TIME',
            ],
            'jam_selesai' => [
                'type' => 'TIME',
            ],
            'ruang' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
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

        $this->forge->addKey('id_jadwal', true); // Primary key
        $this->forge->addForeignKey('id_dosen', 'detail_dosen', 'id_dosen', 'CASCADE', 'CASCADE'); // Relasi ke tabel dosen
        $this->forge->createTable('jadwal_konsultasi');
    }

    public function down()
    {
        $this->forge->dropTable('jadwal_konsultasi');
    }
}
