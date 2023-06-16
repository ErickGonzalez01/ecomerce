<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Bancos extends Migration
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
            "nombre"=>[
                "type"=>"varchar",
                "constraint"=>45
            ],
            "abrebiado"=>[
                "type"=>"varchar",
                "constraint"=>20
            ],
            "ruta_ach"=>[
                "type"=>"varchar",
                "constraint"=>15
            ],
            //Marcado de tiempo
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
        $this->forge->createTable("bancos",true,["ENGINE"=>"InnoDB"]);
    }

    public function down()
    {
        //
        $this->forge->dropTable("bancos");
    }
}
