<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Transacciones extends Migration
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
            "titular"=>[
                "type"=>"varchar",
                "constraint"=>45
            ],
            "monto"=>[
                "type"=>"decimal",
                "constraint"=>"14,2"
            ],
            "forma_pago"=>[
                "type"=>"varchar",
                "constraint"=>45
            ],
            "num_tarjeta"=>[
                "type"=>"int"
            ],
            "banco"=>[
                "type"=>"varchar",
                "constraint"=>45
            ],
            "estado_desembolso"=>[
                "type"=>"varchar",
                "constraint"=>45
            ],
            "numero_ref"=>[
                "type"=>"varchar",
                "constraint"=>45
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
        $this->forge->createTable("transacciones",true,["ENGINE"=>"InnoDB"]);
    }

    public function down()
    {
        //
        $this->forge->dropTable("transacciones");
    }
}
