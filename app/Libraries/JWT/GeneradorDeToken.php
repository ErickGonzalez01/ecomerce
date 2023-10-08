<?php namespace App\Libraries\JWT;

use Firebase\JWT\JWT;

class GeneradorDeToken{
    
    private $time;

    private $data;

    private $type;

    //private 

    /**
     * clase para generar token de recuperacion de passwor y de confirmacion de cuenta
     * @param time tiempo de valides del token
     * @param data datos a incluir en el token
     * @param type especifica el typo de token que se va  generar para password o para confirmacionde cunta
     */
    public function __construct($time,$data,$type)
    {
        $this->$time=$time;

        $this->$data=$data;

        $this->$type=$type;

    }

    /**
     * debuelve el token generado con los parametros que se introdijeron al crear el objeto
     * @return string
     */
    public function Encode():string
    {

        return "";
    }

    public function Decode():bool|array
    {
        return false;
    }

}