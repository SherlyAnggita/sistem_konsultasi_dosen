<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DetailMahasiswa extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_mhs' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'NPM' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'unique'     => true,
            ],
            'nama_mhs' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true,
            ],
            'kelas_mhs' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'prodi_mhs' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'jurusan_mhs' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
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

        $this->forge->addKey('id_mhs', true);
        $this->forge->createTable('detail_mahasiswa');
    }

    public function down()
    {
        $this->forge->dropTable('detail_mahasiswa');
    }
}
