<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DetailDosen extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_dosen' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'NIDN' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'unique'     => true,
            ],
            'nama_dosen' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true,
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

        $this->forge->addKey('id_dosen', true);
        $this->forge->createTable('detail_dosen');
    }

    public function down()
    {
        $this->forge->dropTable('detail_dosen');
    }
}
