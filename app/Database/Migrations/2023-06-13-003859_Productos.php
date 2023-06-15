<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Productos extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            "id"=>[
                "type"=>"int",
                "unique"=>true,
                "unsigned"=>true,
                "auto_increment"=>true
            ],
            "id_vendedor"=>[
                "type"=>"int",
                "unsigned"=>true
            ],
            "id_sub_categoria"=>[
                "type"=>"int",
                "unsigned"=>true
            ],
            "codigo_barra"=>[
                "type"=>"varchar",
                "constraint"=>20,
            ],
            "nombre_producto"=>[
                "type"=>"varchar",
                "constraint"=>45,
            ],
            "descripcion"=>[
                "type"=>"varchar",
                "constraint"=>255,
            ],
            "precio_de_venta"=>[
                "type"=>"decimal",
                "constraint"=>"14,2"
            ],
            "stock"=>[
                "type"=>"int",
                "unsigned"=>true
            ],
            "imagen"=>[
                "type"=>"varchar",
                "constraint"=>75
            ],
            "precio_referencia"=>[
                "type"=>"decimal",
                "constraint"=>"14.2",
                "null"=>true
            ],
            "detalle_producto"=>[
                "type"=>"longtext",
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
        $this->forge->addPrimaryKey("id");
        $this->forge->addForeignKey("id_vendedor","vendedores","id","cascade","restrict");
        $this->forge->addForeignKey("id_sub_categoria","sub_categorias","id","cascade","restrict");
        $this->forge->createTable("productos",true,["ENGINE"=>"InnoDB"]);
    }

    public function down()
    {
        //
        $this->forge->dropTable("productos");
    }
}
