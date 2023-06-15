<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Vendedores extends Migration
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
            "correo"=>[
                "type"=>"varchar",
                "constraint"=>45,
                "unique"=>true
            ],
            "password"=>[
                "type"=>"char",
                "constraint"=>60
            ],
            "nombre_usuario"=>[
                "type"=>"varchar",
                "constraint"=>45,
            ],
            "nombre_del_gerente"=>[
                "type"=>"varchar",
                "constraint"=>65
            ],
            "nombre_negocio"=>[
                "type"=>"varchar",
                "constraint"=>45
            ],
            "razon_social"=>[
                "type"=>"varchar",
                "constraint"=>20
            ],
            "RUC"=>[
                "type"=>"varchar",
                "constraint"=>20
            ],
            "direccion_oficina"=>[
                "type"=>"varchar",
                "constraint"=>"255"
            ],
            "logotipo"=>[
                "type"=>"varchar",
                "constraint"=>60
            ],
            "telefono"=>[
                "type"=>"varchar",
                "constraint"=>12
            ],
            "token_confirmacion"=>[
                "type"=>"varchar",
                "constraint"=>60,
                "null"=>true
            ],
            "token_pasword"=>[
                "type"=>"varchar",
                "constraint"=>60,
                "null"=>true
            ],
            "numero_de_cuenta"=>[
                "type"=>"int",
            ],
            "banco"=>[
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
        $this->forge->addForeignKey("banco","bancos","id","cascade","restrict");
        $this->forge->createTable("vendedores",true,["ENGINE"=>"InnoDB"]);
        

    }

    public function down()
    {
        //
        $this->forge->dropTable("vendedores");
    }
}
