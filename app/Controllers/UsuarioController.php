<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UsuarioModel;
use Firebase\JWT\JWT;

class UsuarioController extends BaseController
{
    use ResponseTrait;

    public function NuevaClave(string $token_password = null){

        helper("form");

        if(!$this->validateData(["token"=>$token_password],["token"=>"required|alpha_numeric|exact_length[60]|is_not_unique[usuarios.token_password]"])){
            return view("errors/html/error_404", ["message" =>"Pagina no encontrada."]);
        }

        $model_usuario = new UsuarioModel();

        $usuario = $model_usuario->where("token_password",$token_password)->first();

        //Para solisitudes get
        if($this->request->is("get")){

            $get_response=[
                "nombre"=>$usuario->nombre." ".$usuario->apellido
            ];
            
            return view("Autenticacion/nuevo_password",$get_response);        
        }

        //Para solicitudes post
        if($this->request->is("post")){

            $pass=$this->request->getVar("nueva_password");

            $validate = $this->validate([
                "nueva_password"            =>      "required|alpha_numeric_punct|min_length[8]|max_length[12]",
                "confirmar_password"        =>      "required|alpha_numeric_punct|min_length[8]|max_length[12]|matches[nueva_password]"
            ],[
                "nueva_password"        =>      [
                    "required"              =>      "La contraseña es obligatoria",
                    "alpha_numeric_punct"   =>      "Solo se permiten los siguientes valores ~!#$%(),&``*-_+=|:.",
                    "min_length"            =>      "La longitud minima es de 8 caracteres",
                    "max_length"            =>      "La longitud maxima es de 12 caracteres",

                ],
                "confirmar_password"    =>      [
                    "required"              =>      "La contraseña es obligatoria",
                    "alpha_numeric_punct"   =>      "Solo se permiten los siguientes valores ~!#$%(),&``*-_+=|:.",
                    "min_length"            =>      "La longitud minima es de 8 caracteres",
                    "max_length"            =>      "La longitud maxima es de 12 caracteres",
                    "matches"               =>      "La contraseña no coincide"
                ]
            ]);
    
            if(!$validate){
                return view("Autenticacion/nuevo_password", ["estado"=>$validate,"error"=>$this->validator->getErrors(),"nombre"=>$usuario->nombre." ".$usuario->apellido]);
            }

            $model_usuario->update($usuario->id,["token_password"=>null,"password"=>password_hash($pass,PASSWORD_BCRYPT)]);

            return view("Autenticacion/ok");           
        }
                       
    }

    public function RecuperarPassword(){

        $correo = $this->request->getVar("correo");

        $validate = $this->validate([
            "correo" => "required|valid_email|is_not_unique[usuarios.correo]"
        ]);

        if (!$validate) {
            return $this->Responder(400, "Correo no existe", ["correo" => $correo]);
        }

        $usuario_model = new UsuarioModel();
        $usuario = $usuario_model->where("correo", $correo)->first();

        if ($usuario->token_password != "" || $usuario->token_password != null) {
            return $this->Responder(200, "Links de recuperacion de contraseña", [], ["url" => base_url() . "/nueva_clave/" . $usuario->token_password]);
        }

        $token = bin2hex(random_bytes(30));

        $usuario_model->update($usuario->id, ["token_password" => $token]);

        return $this->Responder(200, "Se genero link para restablecer contraseña", [], ["nueva_password_url" => base_url() . "/nueva_clave/" . $token]);
    }

    public function Login(){ //post Iniciar sesion
        $data = array(
            "correo" => $this->request->getVar("correo"),
            "password" => $this->request->getVar("password")
        );

        $validate = $this->Validate([
            "correo" => "required|valid_email",
            "password" => "required"
        ], [
            "correo" => [
                "required" => "El campo correo es requerido",
                "valid_email" => "El campo ingresado no se reconoce como en correo"
            ],
            "password" => [
                "required" => "El campo password es obligatorio"
            ]
        ]);

        if (!$validate) {
            //return $this->responder(400, "Error de validacion", $this->validator->getErrors());
            return $this->Responder(404, "Usuario o contraseña incorrectas", ["status" => 404, "error" => "usuario o contraseña incorrecta, por favor verifique e intente nuevamente."]);
        }

        $model = new UsuarioModel();
        $usuarioEntity = $model->where("correo", $data["correo"])->first();

        if ($usuarioEntity == null || !password_verify($data["password"], $usuarioEntity->password)) {
            return $this->Responder(404, "Usuario o contraseña incorrectas", ["status" => 404, "error" => "usuario o contraseña incorrecta, por favor verifique e intente nuevamente."]);
        }

        $tokenExiste = $usuarioEntity->token_confirmacion;

        if (!$tokenExiste == null) {
            return $this->Responder(401, "Error de confirmacion de cuenta", [
                "informacion" => "Por favor ingrese a esta url para confirmar su cuenta",
                "url_confirm" => base_url() . "/confirmar_registro/" . $tokenExiste
            ]);
        }

        //token JWT

        $key = getenv("JWT_SECRET");
        $iat = time();
        $exp = $iat + 3600;

        $payload = array(
            "iss" => base_url(),
            "aud" => base_url(),
            "sub" => $usuarioEntity->correo,
            "iat" => $iat,
            "exp" => $exp,
            "data" => [
                "nombre" => $usuarioEntity->nombre,
                "apellido" => $usuarioEntity->apellido
            ]
        );

        $token = JWT::encode($payload, $key, "HS256");
        return $this->Responder(200, "Se a iniciado secion correctamente", [], ["token" => $token, "nombre" => $usuarioEntity->nombre, "apellido" => $usuarioEntity->apellido, "correo" => $usuarioEntity->correo]);
    }
    public function Signup(){ //post Registrarse

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
            "token_confirmacion" => bin2hex(random_bytes(30)) //uniqid("qwerty", true)
        );

        //Validacion
        $validate = $this->validate([
            "nombre" => "required",
            "apellido" => "required",
            "fecha_nacimiento" => "required|valid_date[Y-m-d]",
            "telefono" => "required",
            "correo" => "required|valid_email|is_unique[usuarios.correo]",
            "password" => "required|alpha_numeric_punct|min_length[8]|max_length[12]",
            "password_comfirm" => "required|alpha_numeric_punct|min_length[8]|max_length[12]|matches[password]",
            "direccion" => "required|min_length[15]|max_length[255]",
            "departamento" => "required",
            "municipio" => "required",
            "barrio_comarca_colonia" => "required"
        ]);

        //Validacion fallida
        if (!$validate) {
            return $this->responder(500, "Error al validar las entradas o correo ya existe.", $this->validator->getErrors());
        } //

        //Insertando el usuario
        $model = new UsuarioModel();
        $model->insert($data);

        //Respuesta exitosa

        //Respuesta para "php spark serve"
        return $this->responder(201, "Se a registrado con exito", [], ["url_confirm" => base_url() . "/confirmar_registro/" . $data["token_confirmacion"]]);

        //Respuesta para apache proxy inverso
        //return $this->responder(201, "Se a registrado con exito", [], ["url_confirm" => "http://192.168.1.3/api/" . "confirmar_registro/" . $data["token_confirmacion"]]);
    }
    public function Logout()
    { //get Cerrar sesion #[Not Fount]
        //helper("usuario");//
        helper('usuario');
        $data = GetDataUsuarioToken($this->request);
        //$this->setcookie("session",[],3600);
        return $this->respond(["OK" => $data], 201);
    }

    public function ConfirmarCuenta($token = null)
    { //get-post Confirmar cuenta de usuario

        //Confirmar cuenta del usuario
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
            return view("errors/html/error_404", ["message" => "A ocurrido un error."]);
        }

        //Obteniendo metodo de la solicitud
        $method = $this->request->getMethod();

        //Modelo del usuario
        $model = new UsuarioModel();

        //Entidad del usuario
        $usuario = $model->where("token_confirmacion", $token)->first();

        //Valor que el usuario enviara al aceptar terminos y condiciones
        $aceptar = $this->request->getVar("aceptar");

        //Contiene informacion sobre si el usuario envio algun dato 
        $aceptar_boll = true;

        //evalua si el usuario envio algun dato y asigna true o false al avariable $aceptar_boll
        if ($aceptar === null && $aceptar != "on" && $method == "post") {
            $aceptar_boll = false;
        }

        //Datos de respuesta para una soicitud get o si $aceptar_boll es false
        $data_respuesta_get = [
            "usuario" => $usuario->nombre . " " . $usuario->apellido,
            "url" => "http://" . $this->request->getServer("HTTP_HOST") . $this->request->getServer("PATH_INFO"),
            "danger" => $aceptar_boll
        ];

        //datos de respuesta para una solicitud post
        $data_respuesta_post = [
            "usuario" => $usuario->nombre
        ];

        //realiza acciones para un metodo get
        if ($method == "get") { //method get           

            return view("Autenticacion/confirmar_registro", $data_respuesta_get);
        }

        //realiza acciones para un metodo post
        if ($method == "post") { //methos post

            if ($aceptar_boll == false) {
                return view("Autenticacion/confirmar_registro", $data_respuesta_get);
            }
            $model->update($usuario->id, ["token_confirmacion" => ""]);
            return view("Autenticacion/exito_confirmacion", $data_respuesta_post);
        }
        if ($method !== "get" || $method !== "post") {
            echo "a ocurrido un error";
            return;
        }
    }

    /**
     * Cadena de texto aleatorio alfanumerico de 60 caracteres
     * @return IResponse
     */
    public function Test()
    { //Metodo de prueva puede eleiminarse con el tiempo        
        $randomString = bin2hex(random_bytes(30));
        return $this->respond(["Test" => "es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona", "has_60" => $randomString], 200, "Test");
    }

    /**
     * Metodo de respuesta para el controlador
     * @param status es el estado de la solicitud
     * @param mensaje es el mensaje que se envia respondiendo a la solicitud
     * @param error si a de ocurrir un error aqui se detallan
     * @param data son los datos asociados a la solicitud
     * @return ResponseInterface devuelve una respuesta json
     */
    private function Responder($status = 200, $mensaje, $error = [], $data = []) // Method Formato de respuesta para este controlador
    {
        return $this->respond([
            "status" => $status,
            "mensaje" => $mensaje,
            "error" => $error,
            "data" => $data
        ], $status);
    }
}
