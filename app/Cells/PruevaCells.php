<?php namespace App\Cells;

class PruevaCells{

    public function Show(array $param):string{

        return "<p>Este es un Cells de prueva y estos son sus parametros {$param['hola']}</p>";

    }

    public function Alert(array $param){
        $implode = "• " . implode(" <br> • ",$param["error"]);
        //return "<div class=\"alert alert-{$param["type"]}\" role=\"alert\">{$param["msg"]}</div>";
        return "<div class=\"alert alert-{$param["type"]}\" role=\"alert\">$implode</div>";
    }

}