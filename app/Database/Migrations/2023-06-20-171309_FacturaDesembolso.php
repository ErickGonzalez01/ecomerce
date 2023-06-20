<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FacturaDesembolso extends Migration
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
            "id_desembolso"=>[
                "type"=>"int",
                "unsigned"=>true
            ],
            "id_transaction"=>[
                "type"=>"int",
                "unsigned"=>true
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
        $this->forge->addForeignKey("id_desembolso","registros_desembolsos","id","cascade","restrict");
        $this->forge->addForeignKey("id_transaction","transacciones","id","cascade","restrict");
        $this->forge->createTable("facturas_desembolsos",true,["ENGINE"=>"InnoDB"]);
    }

    public function down()
    {
        //
        $this->forge->dropTable("facturas_desembolsos",true);
    }
}
