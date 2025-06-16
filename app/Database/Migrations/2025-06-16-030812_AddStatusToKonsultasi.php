<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusToKonsultasi extends Migration
{
   public function up()
    {
        $fields = [
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['menunggu', 'disetujui', 'ditolak'],
                'default'    => 'menunggu',
                'after'      => 'topik', // letakkan setelah kolom 'topik'
            ],
        ];
        $this->forge->addColumn('konsultasi', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('konsultasi', 'status');
    }
}
