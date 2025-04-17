<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DetailKonsultasi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_konsultasi' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_mhs' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'id_dosen' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'nama_mhs' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true,
            ],
            'nama_dosen' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true,
            ],
            'tgl_konsultasi' => [
                'type'       => 'date',
                'constraint' => '',
            ],
            'topik' => [
                'type'       => 'TEXT',
                'constraint' => '255',
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
        ]);

        $this->forge->addKey('id_konsultasi', true);
        $this->forge->createTable('konsultasi');
    }

    public function down()
    {
        $this->forge->dropTable('konsultasi');
    }
}
