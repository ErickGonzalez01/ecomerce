<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;

use \Firebase\JWT\JWT;

class UserController extends BaseController{
    use ResponseTrait;

    //Informacion del usuario ["get"]
    public function info(){
        $userModel = new UserModel();

        $correo = $this->request->getVar("correo");

        $validate=$this->validate([
            "correo"=>"required|valid_email"
        ]);

        if(!$validate){
            return $this->respond(["error"=>$this->validator->getErrors()],404);
        }
        
        $informacion=$userModel->select("nombre,apellido,fecha_nacimiento,telefono,direccion,correo,departamento,municipio,barrio_comarca_colonia")->where("correo",$correo)->first();

        if(is_null($informacion)){
            return $this->respond(["error"=>"No se encontraron coinsidencias"],404);
        }
        //echo gettype($informacion);
        return $this->respond($informacion,200);        
    }

    //Inicio de sescion del usuario
    public function index(){
        $userModel = new UserModel();       

        $validate = $this->validate([
            "correo"=>"required|valid_email",
            "password"=>"required"
        ]);

        if(!$validate){
            return $this->respond(["error"=>$this->validator->getErrors()],401);
        }

        $email = $this->request->getVar("correo");
        $password = $this->request->getVar("password");
        $user = $userModel->where("correo",$email)->first();

        if(is_null($user)){
            return $this->respond(["error"=>"No se encontro un usuario con estos datos"],401);
        }

        $pwd_verify = password_verify($password,$user["password"]);

        if(!$pwd_verify){
            return $this->respond(["error"=>"Contraseña o correo invalidos","sesion"=>false],401);
        }

        $key = getenv("JWT_SECRET");
        $iat = time();
        $exp = $iat+3600;

        $payload = array(
            "iss" => "Issuer of the JWT",
            "aud" => "Audience that the JWT",
            "sub" => "Subject of the JWT",
            "iat" => $iat,
            "exp" => $exp,
            "usuario" => [
                "nombre"=>$user["nombre"],
                "apellido"=>$user["apellido"],
                "fecha_nacimiento"=>$user["fecha_nacimiento"],
                "telefono"=>$user["telefono"],
                "direccion"=>$user["direccion"],
                "correo"=>$user["correo"],
                "departamento"=>$user["departamento"],
                "municipio"=>$user["municipio"],
                "barrio_comarca_colonia"=>$user["barrio_comarca_colonia"]
            ]
        );

        //$token = JWT::encode($payload,$key,"HS256"); //JWT::encode($payload,$key,"HS256");
        $token = JWT::encode($payload,$key,"HS256");
        $response = [
            "Messague"  => "Inicio de sescion exitoso",
            "token"     => $token,
            "sesion"   =>true,
            "user"      =>[
                "nombre"                    =>  $user["nombre"],
                "apellido"                  =>  $user["apellido"],
                "fecha_nacimiento"          =>  $user["fecha_nacimiento"],
                "telefono"                  =>  $user["telefono"],
                "direccion"                 =>  $user["direccion"],
                "correo"                    =>  $user["correo"],
                "departamento"              =>  $user["departamento"],
                "municipio"                 =>  $user["municipio"],
                "barrio_comarca_colonia"    =>  $user["barrio_comarca_colonia"]
            ]
        ];

        return $this->respond($response,201);

    }

    //Registro del usuario
    public function post(){
        $rules = $this->validate([
            "nombre" => "required|max_length[45]",
            "apellido" => "required|max_length[45]",
            "fecha_nacimiento"=>"required",
            "telefono"=>"required",
            "direccion"=>"required|max_length[255]",
            "correo"=>"required|valid_email|is_unique[usuarios.correo]",
            "password"=>"required|max_length[12]",
            "password_confirm"=>"required|matches[password]|max_length[12]",
            "departamento"=>"required",
            "municipio"=>"required",
            "barrio_comarca_colonia"=>"required"
        ]);

        if(!$rules){
            $responseError=[
                "error" => $this->validator->getErrors(),
                "message" => "Invalid inputs"
            ];
            return $this->respond($responseError,401);
        }

        $userModel = new UserModel();

        $data = [
            "nombre"=>$this->request->getVar( "nombre"),
            "apellido"=>$this->request->getVar("apellido"),
            "fecha_nacimiento"=>$this->request->getVar("fecha_nacimiento"),
            "telefono"=>$this->request->getVar("telefono"),
            "direccion"=>$this->request->getVar("direccion"),
            "correo"=>$this->request->getVar("correo"),
            "password"=> password_hash($this->request->getVar("password"),PASSWORD_BCRYPT),
            "departamento"=>$this->request->getVar("departamento"),
            "municipio"=>$this->request->getVar("municipio"),
            "barrio_comarca_colonia"=>$this->request->getVar("barrio_comarca_colonia")
        ];
        
        $userModel->save($data);
        return $this->respond(["message"=>"Registered successfully"],201);
    }
}

?>