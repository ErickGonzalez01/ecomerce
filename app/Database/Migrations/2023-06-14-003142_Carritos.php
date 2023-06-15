<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Carritos extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            "id"=>[
                "type"=>"int",
                "unique"=>true,
                "unsigned"=>true,
                "auto_incremento"=>true
            ],
            "id_usario"=>[
                "type"=>"int",
                "unsigned"=>true
            ],
            "id_producto"=>[
                "type"=>"int",
                "unsigned"=>true
            ],
            "cantidad"=>[
                "type"=>"int",
                "unsigned"=>true,
                "default"=>1
            ],
            "total"=>[
                "type"=>"decimal",
                "constraint"=>"14,2",
                "unsigned"=>true
            ],
            "processing"=>[
                "type"=>"boolean",
                "null"=>true
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
        //$this->forge->addField("total decimal(14,2) as (cantidad * (select precio_de_venta from productos where productos.id=carritos.id_producto))");
        $this->forge->addPrimaryKey("id");
        $this->forge->addForeignKey("id_usario","usuarios","id","cascade","restict");
        $this->forge->addForeignKey("id_producto","productos","id","cascade","restrict");
        $this->forge->createTable("carritos",true,["ENGINE"=>"InnoDB"]);
        //$this->forge->modifyColumn("carritos",["total"=>"total decimal(14,2) as (cantidad * (select precio_de_venta from productos where productos.id=carritos.id_producto))"]);
    }

    public function down()
    {
        //
        $this->forge->dropTable("carritos");
    }
}
