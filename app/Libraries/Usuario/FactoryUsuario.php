<?php   namespace App\Libraries\Usuario;

    use App\Libraries\Usuario\UsuarioType;
    use App\Models\UserModel;
    use App\Libraries\Usuario\IFactoryUsuario;

    class FactoryUsuario implements IFactoryUsuario {

        public static function getInstance($usuarioType){
            switch($usuarioType){
                case UsuarioType::Usuario:
                    return new UserModel;
                break;
                default:
                    throw "UsuarioType Undefaund";
            }
        }
    }
?>