<?php 

use CodeIgniter\Test\CIUnitTestCase;
//use CodeIgniter\Test\

final class UsuarioControllerTest extends CIUnitTestCase{

    public function ExisteMethodGetUsuarioToken(){
        helper("usuario");
        $this->assertArrayHasKey(["hola","two"],GetDataUsuarioToken());
    }


}