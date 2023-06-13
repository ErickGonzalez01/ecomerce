<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Categorias extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            "id"        => [
                "type"                  =>"INT",
                "auto_increment"        =>true,
                "unique"                =>true,
                "unsigned"              =>true,
        
            ],
            "nombre"    =>[
                "type"                  =>"VARCHAR",
                "constraint"            =>20,
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
        $this->forge->createTable("categorias",false,["ENGINE"=>"InnoDB"]);
    }

    public function down()
    {
        //
        $this->forge->dropTable("categorias");
    }
}
