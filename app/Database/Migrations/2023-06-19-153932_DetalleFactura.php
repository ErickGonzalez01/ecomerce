<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DetalleFactura extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            "id"=>[
                "type"=>"int",
                "unsigned"=>true,
                "auto_increment"=>true,
                "unique"=>true
            ],
            "id_factura"=>[
                "type"=>"int",
                "unsigned"=>true
            ],
            "id_producto"=>[
                "type"=>"int",
                "unsigned"=>true
            ],
            "cantidad"=>[
                "type"=>"int",
                "unsigned"=>true
            ],
            "total"=>[
                "type"=>"decimal",
                "constraint"=>"14,2"
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
        $this->forge->addPrimaryKey("id");
        $this->forge->addForeignKey("id_factura","facturas_registros","id","cascade","restrict");
        $this->forge->addForeignKey("id_producto","productos","id","cascade","restrict");
        $this->forge->createTable("detalles_facturas",true,["ENGINE"=>"InnoDB"]);
    }

    public function down()
    {
        //
        $this->forge->dropTable("detalles_facturas",true);
    }
}
