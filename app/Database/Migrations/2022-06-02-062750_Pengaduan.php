<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pengaduan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pengaduan'          => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama'       => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'nik'       => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'nomor_hp' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'jenis_aduan' => [
                'type'  => 'ENUM',
                'constraint' => ['Patroli', 'Pengamanan', 'Penanganan Orang Terlantar', 'Penanganan ODGJ'],
            ],
            'sasaran' => [
                'type' => 'TEXT',
            ],
            'waktu' => [
                'type' => 'TIME',
            ],
            'tgl_pengaduan' => [
                'type' => 'DATE',
            ],
            'lokasi' => [
                'type' => 'TEXT',
            ],
            'id_kecamatan'          => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
            ],
            'status' => [
                'type'  => 'ENUM',
                'constraint' => ['Pending', 'Terverifikasi'],
                'default' => 'Pending',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'tindakan'       => [
                'type'       => 'TEXT',
                'null' => true,

            ],
            'keterangan' => [
                'type' => 'TEXT',
                'constraint' => null,
                'null' => true,
            ],
            'upload_foto' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
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
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

        ]);
        $this->forge->addKey('id_pengaduan', true);
        $this->forge->addForeignKey('id_kecamatan', 'pengaduan', 'id_pengaduan');
        $this->forge->createTable('pengaduan');
    }

    public function down()
    {
        $this->forge->dropTable('pengaduan');
    }
}
