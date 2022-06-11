<?php
    namespace App\Database\Migrations;
    
    use CodeIgniter\Database\Migration;
    
    class JenisAduan extends Migration
    {
        public function up()
        {
            $this->forge->addField([
    
                'id_kecamatan'          => [
                    'type'           => 'INT',
                    'constraint'     => 10,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'keterangan'       => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                ],
            ]);
            $this->forge->addKey('id_kecamatan', true);
            $this->forge->createTable('id_kecamatan');
        
    
        }
    
        public function down()
        {
            $this->forge->dropTable('kecamatan');
        }
    }
    