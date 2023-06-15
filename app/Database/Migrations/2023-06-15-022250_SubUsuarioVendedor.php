<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SubUsuarioVendedor extends Migration
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
            "usuario_raiz"=>[
                "type"=>"int",
                "unsigned"=>true
            ],
            "nombre"=>[
                "type"=>"varchar",
                "constraint"=>45
            ],
            "apellido"=>[
                "type"=>"varchar",
                "constraint"=>45
            ],
            "roll"=>[
                "type"=>"varchar",
                "constraint"=>60,
                "null"=>true
            ]

        ]);
        $this->forge->addPrimaryKey("id");
        $this->forge->addForeignKey("usuario_raiz","vendedores","id","cascade","restrict");
        $this->forge->createTable("sub_usuario_vendedor",true,["ENGINE"=>"InnoDB"]);
    }

    public function down()
    {
        //
        $this->forge->dropTable("sub_usuario_vendedor");
    }
}
