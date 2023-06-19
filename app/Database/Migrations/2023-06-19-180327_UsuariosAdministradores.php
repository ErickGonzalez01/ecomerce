<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UsuariosAdministradores extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            "id"=>[
                "type"=>"int",
                "unsigned"=>true,
                "unique"=>true,
                "auto_increment"=>true
            ],
            "usuario"=>[
                "type"=>"varchar",
                "constraint"=>45,
                "unique"=>true
            ],
            "password"=>[
                "type"=>"char",
                "constraint"=>60
            ],
            "nombre"=>[
                "type"=>"varchar",
                "constraint"=>45
            ],
            "apellido"=>[
                "type"=>"varchar",
                "constraint"=>45
            ],
            "rolles"=>[
                "type"=>"varchar",
                "constraint"=>45
            ],            
            //marcas de tiempo
            'created_at'=>[
                "type"=>"TIMESTAMP",
                "null"=>true
            ],
            'updated_at'=>[
                "type"=>"TIMESTAMP",
                "null"=>true
            ],
            'deleted_at'=>[
                "type"=>"TIMESTAMP",
                "null"=>true
            ]
        ]);
        
    }

    public function down()
    {
        //
    }
}
