<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use PHPUnit\Framework\Constraint\Constraint;

class AddUser extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            "id"=>[
                "type"=>"INT",
                "unsigned"=>true,
                "auto_increment"=>true,
                "null"=>false
            ],
            "nombre"=>[
                "type"=>"VARCHAR",
                "constraint"=>45,
                "null"=>false
            ],
            "apellido"=>[
                "type"=>"VARCHAR",
                "constraint"=>45,
                "null"=>false
            ],
            "fecha_nacimiento"=>[
                "type"=>"DATE",
                "null"=>false
            ],
            "telefono"=>[
                "type"=>"VARCHAR",
                "constraint"=>15,
                "null"=>false
            ],
            "correo"=>[
                "type"=>"VARCHAR",
                "unique"=>true,
                "null"=>false,
                "constraint"=>60
            ],
            "password"=>[
                "type"=>"CHAR",
                "null"=>false,
                "constraint"=>60
            ],
            "direccion"=>[
                "type"=>"VARCHAR",
                "constraint"=>255,
                "null"=>false
            ],
            "departamento"=>[
                "type"=>"VARCHAR",
                "constraint"=>45,
                "null"=>false
            ],
            "municipio"=>[
                "type"=>"VARCHAR",
                "constraint"=>45,
                "null"=>false
            ],
            "barrio_comarca_colonia"=>[
                "type"=>"VARCHAR",
                "constraint"=>60,
                "null"=>false
            ],
            'created_at'=>[
                "type"=>"TIMESTAMP",
                "null"=>"true"
            ],
            'updated_at'=>[
                "type"=>"TIMESTAMP",
                "null"=>"true"
            ],
            'deleted_at'=>[
                "type"=>"TIMESTAMP",
                "null"=>"true"
            ]
        ]);
        $this->forge->addPrimaryKey("id");
        $this->forge->createTable("usuarios");
    }

    public function down()
    {
        //
        $this->forge->dropTable("usuarios");
    }
}