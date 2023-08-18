<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use PhpParser\Node\Stmt\TryCatch;

/**
 * UsuarioHerpers ayuda a extraer los datos del usuario decodificando el jwt token 
 * @return array
 */
function UsuarioHelpers (){
    return "Hola";
}

/**
 * Obtener datos de usuario del token
 * @param IRequest
 * @return array
 */
function GetDataUsuarioToken($request):array{
    $key = getenv("JWT_SECRET");
    $token =explode(" ",$request->getServer("HTTP_AUTHORIZATION"))[1] ?? "";
    try{
        $jwt = JWT::decode($token, new Key($key, "HS256"));
    }catch(Exception $e){
        return ["Error"=>$e->getMessage()];
    }    
    return (array) $jwt->data;
}