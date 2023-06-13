<?php   namespace App\Libraries\Usuario;    

    interface IFactoryUsuario{
        public static function getInstance(UsuarioType $usuarioType);
    }
?>