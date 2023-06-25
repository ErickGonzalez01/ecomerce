<?php namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UsuarioModel;

class UsuarioController extends BaseController
{
    use ResponseTrait;

    public function Login(){//post
        //Iniciar sesion
        $data=array(
            "correo"=>$this->request->getVar("correo"),
            "password"=>$this->request->getVar("password")
        );

        $validate=$this->Validate([
            "correo"=>"required|valid_email",
            "password"=>"required"
        ],[
            "correo"=>[
                "required"=>"El campo correo es requerido",
                "valid_email"=>"El campo ingresado no se reconoce como en correo"
            ],
            "password"=>[
                "required"=>"El campo password es obligatorio"
            ]
        ]);

        if(!$validate){
            return $this->responder(400,"Error de validacion",$this->validator->getErrors());
        }

        $model = new UsuarioModel();
        $usuarioEntity= $model->where("correo",$data["correo"])->first();

        $tokenExiste=$usuarioEntity->token_confirmacion;


        if(!$tokenExiste==null){
            return $this->Responder(401,"Error de confirmacion de cuenta",[
                "informacion"=>"Por favor ingrese a esta url para confirmar su cuenta",
                "url_confirm"=>base_url()."confirmar_registro/".$tokenExiste
            ]);
        }

        //
        //
        //

        return $this->respond($_POST,201);
    }
    public function Signup(){//post
        //Registrarse

        //Datos del post        
        $data = array(
            "nombre" => $this->request->getVar("nombre"),
            "apellido" => $this->request->getVar("apellido"),
            "fecha_nacimiento" => $this->request->getVar("fecha_nacimiento"),
            "telefono" => $this->request->getVar("telefono"),
            "correo" => $this->request->getVar("correo"),
            "password" => password_hash($this->request->getVar("password"),PASSWORD_BCRYPT),
            "direccion" => $this->request->getVar("direccion"),
            "departamento" => $this->request->getVar("departamento"),
            "municipio" => $this->request->getVar("municipio"),
            "barrio_comarca_colonia" => $this->request->getVar("barrio_comarca_colonia"),
            "token_confirmacion"=>uniqid("qwerty",true)
        );

        //Validacion
        $validate = $this->validate([
            "nombre" => "required",
            "apellido" => "required",
            "fecha_nacimiento" => "required|valid_date[d/m/Y]",
            "telefono" => "required",
            "correo" => "required|valid_email|is_unique[usuarios.correo]",
            "password" => "required|alpha_numeric_punct|min_length[8]|max_length[12]",
            "password_comfirm" => "required|alpha_numeric_punct|min_length[8]|max_length[12]|matches[password]",
            "direccion" => "required|min_length[45]|max_length[255]",
            "departamento" => "required",
            "municipio" => "required",
            "barrio_comarca_colonia" => "required"              
        ]);
        
        //Validacion fallida
        if(!$validate){
            return $this->responder(500,"Error al validar las entradas",$this->validator->getErrors());         
        }
        
        //Insertando el usuario
        $model = new UsuarioModel();
        $model->insert($data);
        
        //Respuesta exitosa
        return $this->responder(201,"Se a registrado con exito",[],["url_confirm"=>base_url()."confirmar_registro/".$data["token_confirmacion"]]);        
    }
    public function Logout(){//get
        //Cerrar sesion
        return $this->respond($_GET,201);
    }
    public function ConfirmarCuenta($token){
        $method = $this->request->getMethod();
        helper("form");

        $data = array(
            "token"=>$token
        );
        $rule = array(
            "token"=>"is_not_unique[usuarios.token_confirmacion,$token]"
        );

        if(!$this->validateData($data,$rule)){
            return $this->response->setBody("Error");
        }

        $model = new UsuarioModel();
        $usuario = $model->where("token_confirmacion",$token);

        switch ($method){
            case "post":
                return "hola";
                break;
            case "get":
                $dataUsuario=[
                    "nombre_apellido"=>$usuario->nombre . " " . $usuario->apellido
                ];
                return view("Autenticacion/confirmar_registro",$dataUsuario);
                break;
        }

       
        
    }    

    /**
     * Metodo de respuesta para el controlador
     * @param status es el estado de la solicitud
     * @param mensaje es el mensaje que se envia respondiendo a la solicitud
     * @param error si a de ocurrir un error aqui se detallan
     * @param data son los datos asociados a la solicitud
     */
    private function Responder($status=200,$mensaje,$error=[],$data=[]){
        return $this->respond([
            "status"=>$status,
            "mensaje"=>$mensaje,
            "error"=>$error,
            "data"=>$data
        ],$status);
    }
}
