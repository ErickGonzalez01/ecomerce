<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FacturaRegistro extends Migration
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
            "fecha"=>[
                "type"=>"datetime"
            ],
            "id_usuario"=>[
                "type"=>"int",
                "unsigned"=>true
            ],
            "id_vendedor"=>[
                "type"=>"int",
                "unsigned"=>true
            ],
            "id_transaccion"=>[
                "type"=>"int",
                "unsigned"=>true
            ],
            "total_factura"=>[
                "type"=>"decimal",
                "constraint"=>"14,2"
            ],
            "estado_pedido"=>[
                "type"=>"varchar",
                "constraint"=>45
            ],
            "seguimiento"=>[
                "type"=>"varchar",
                "constraint"=>45
            ],
            "comicion"=>[
                "type"=>"decimal",
                "constraint"=>"14,2"
            ],
            "total_desembolso"=>[
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
        $this->forge->addForeignKey("id","transacciones","id","cascade","restrict");
        $this->forge->createTable("facturas_registros",true,["ENGINE"=>"InnoDB"]);
    }

    public function down()
    {
        //
        $this->forge->dropTable("facturas_registros");
    }
}
