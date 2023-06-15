<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SubCategorias extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            "id"=>[
                "type"=>"int",
                "auto_increment"=>true,
                "unsigned"=>true,
                "unique"=>true
            ],
            "id_categoria"=>[
                "type"=>"int",
                "unsigned"=>true
            ],
            "nombre"=>[
                "type"=>"varchar",
                "constraint"=>45
            ],
            //Marcas de tiempo
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
        $this->forge->addPrimaryKey("id");
        $this->forge->addForeignKey("id_categoria","categorias","id","cascade","no action");
        $this->forge->createTable("sub_categorias",true,["ENGINE"=>"InnoDB"]);
    }

    public function down()
    {
        //
        $this->forge->dropTable("sub_categorias");
    }
}
