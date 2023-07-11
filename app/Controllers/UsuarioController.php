<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\UsuarioEntity;
use App\Libraries\Usuario\UsuarioType;
use CodeIgniter\API\ResponseTrait;
use App\Models\UsuarioModel;
use Firebase\JWT\JWT;

class UsuarioController extends BaseController
{
    use ResponseTrait;

    public function Login()
    { //post

        //Iniciar sesion
        $data = array(
            "correo" => $this->request->getVar("correo"),
            "password" => $this->request->getVar("password")
        );

        $validate = $this->Validate([
            "correo" => "required|valid_email",
            "password" => "required"
        ],[
            "correo" => [
                "required" => "El campo correo es requerido",
                "valid_email" => "El campo ingresado no se reconoce como en correo"
            ],
            "password" => [
                "required" => "El campo password es obligatorio"
            ]
        ]);

        if (!$validate) {
            return $this->responder(400, "Error de validacion", $this->validator->getErrors());
        }

        $model = new UsuarioModel();
        $usuarioEntity = $model->where("correo", $data["correo"])->first();

        $tokenExiste = $usuarioEntity->token_confirmacion;


        if (!$tokenExiste == null) {
            return $this->Responder(401, "Error de confirmacion de cuenta", [
                "informacion" => "Por favor ingrese a esta url para confirmar su cuenta",
                "url_confirm" => base_url() . "confirmar_registro/" . $tokenExiste
            ]);
        }

        if(!password_verify($data["password"],$usuarioEntity->password)){
            return $this->Responder(404,"Usuario o contraseña incorrectas",["status"=>404,"error"=>"usuario o contraseña incorrecta, por favor verifique e intente nuevamente."]);

        }

        //token JWT

        $key = getenv("JWT_SECRET");
        $iat = time();
        $exp = $iat+30;

        $payload = array(
            "iss" => base_url(),
            "aud" => base_url(),
            "sub" => $usuarioEntity->correo,
            "iat" => $iat,
            "exp" => $exp,
            "data" => [
                "nombre"=>$usuarioEntity->nombre,
                "apellido"=>$usuarioEntity->apellido
            ]
        );

        $token = JWT::encode($payload,$key,"HS256");
        return $this->Responder(200,"Se a iniciado secion correctament",[],["token"=>$token,"nombe"=>$usuarioEntity->nombre,"apellido"=>$usuarioEntity->apellido]);
    }
    public function Signup()
    { //post
        //Registrarse

        //Datos del post        
        $data = array(
            "nombre" => $this->request->getVar("nombre"),
            "apellido" => $this->request->getVar("apellido"),
            "fecha_nacimiento" => $this->request->getVar("fecha_nacimiento"),
            "telefono" => $this->request->getVar("telefono"),
            "correo" => $this->request->getVar("correo"),
            "password" => password_hash($this->request->getVar("password"), PASSWORD_BCRYPT),
            "direccion" => $this->request->getVar("direccion"),
            "departamento" => $this->request->getVar("departamento"),
            "municipio" => $this->request->getVar("municipio"),
            "barrio_comarca_colonia" => $this->request->getVar("barrio_comarca_colonia"),
            "token_confirmacion" => uniqid("qwerty", true)
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
        if (!$validate) {
            return $this->responder(500, "Error al validar las entradas", $this->validator->getErrors());
        }

        //Insertando el usuario
        $model = new UsuarioModel();
        $model->insert($data);

        //Respuesta exitosa
        return $this->responder(201, "Se a registrado con exito", [], ["url_confirm" => base_url() . "confirmar_registro/" . $data["token_confirmacion"]]);
    }
    public function Logout()
    { //get
        //Cerrar sesion
        return $this->respond($_GET, 201);
    }

    public function ConfirmarCuenta($token=null)
    { //get ]=[ post

        //Importando ayudantes
        helper("security");
        helper("form");

        //Pasando el token capturado en la url al data
        $data = array(
            "token" => $token
        );

        //Rglas de validacion para data
        $rule = array(
            "token" => "required|exact_length[60]|alpha_numeric|is_not_unique[usuarios.token_confirmacion,token_confirmacion,$token]"
        );

        //Validaicon de token almacenado en data
        if (!$this->validateData($data, $rule)) {
            return view("errors/html/error_404",["message"=>"A ocurrido un error."]);
        }

        //Obteniendo metodo fr la solicitud
        $method = $this->request->getMethod();

        //Modelo del usuario
        $model = new UsuarioModel();  
        
        //Entidad del usuario
        $usuario = $model->where("token_confirmacion", $token)->first(); 
        
        //Valor que el usuario enviara al aceptar terminos y condiciones
        $aceptar = $this->request->getVar("aceptar");

        //Contiene informacion sobre si el usuario envio algun dato 
        $aceptar_boll=true;

        //evalua si el usuario envio algun dato y asigna true o false al avariable $aceptar_boll
        if($aceptar === null && $aceptar !="on" && $method=="post"){
                $aceptar_boll = false;
        }

        //Datos de respuesta para una soicitud get o si $aceptar_boll es false
        $data_respuesta_get=[
            "usuario"=>$usuario->nombre . " " . $usuario->apellido,
            "url"=> "http://" . $this->request->getServer("HTTP_HOST") . $this->request->getServer("PATH_INFO"),
            "danger"=>$aceptar_boll
        ];

        //datos de respuesta para una solicitud post
        $data_respuesta_post=[
            "usuario"=>$usuario->nombre
        ];

        //realiza acciones para un metodo get
        if($method == "get"){//method get           

            return view("Autenticacion/confirmar_registro",$data_respuesta_get);
        }

        //realiza acciones para un metodo post
        if($method == "post"){//methos post

            if($aceptar_boll == false){
                return view("Autenticacion/confirmar_registro",$data_respuesta_get);
            }
            $model->update($usuario->id,["token_confirmacion"=>""]);
            return view("Autenticacion/exito_confirmacion",$data_respuesta_post);
        }
        if($method !== "get" || $method !== "post"){
            echo "a ocurrido un error";
            return;
        }      
    }

    public function Test(){
        return $this->respond(["Test"=>"es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona"],200,"Test");
    }

    /**
     * Metodo de respuesta para el controlador
     * @param status es el estado de la solicitud
     * @param mensaje es el mensaje que se envia respondiendo a la solicitud
     * @param error si a de ocurrir un error aqui se detallan
     * @param data son los datos asociados a la solicitud
     * @return Respond devuelve una respuesta json
     */
    private function Responder($status = 200, $mensaje, $error = [], $data = [])
    {
        return $this->respond([
            "status" => $status,
            "mensaje" => $mensaje,
            "error" => $error,
            "data" => $data
        ], $status);
    }
}