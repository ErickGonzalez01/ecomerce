<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RegistrosDesembolsos extends Migration
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
            "fecha"=>[
                "type"=>"datetime"
            ],
            "id_vendedor"=>[
                "type"=>"int",
                "unsigned"=>true
            ],
            "realizado_por"=>[
                "type"=>"int",
                "unsigned"=>true
            ],
            "monto_facturas"=>[
                "type"=>"decimal",
                "constraint"=>"14,2"
            ],
            "monto_comicion"=>[
                "type"=>"decimal",
                "constraint"=>"14,2"
            ],
            "monto_desembolso"=>[
                "type"=>"decimal",
                "constraint"=>"14,2"
            ],
            "referencia_banco"=>[
                "type"=>"int"
            ],
            "no_cuenta"=>[
                "type"=>"int"
            ],
            "monto_banco_comicion"=>[
                "type"=>"decimal",
                "constraint"=>"14,2"
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
        $this->forge->addForeignKey("id_vendedor","vendedores","id","cascade","restrict");
        $this->forge->addForeignKey("realizado_por","usuarios_administradors","id","cascade","restrict");
        $this->forge->createTable("registros_desembolsos",true,["ENGINE"=>"InnoDB"]);
    }

    public function down()
    {
        //
        $this->forge->dropTable("registros_desembolsos",true);
    }
}
