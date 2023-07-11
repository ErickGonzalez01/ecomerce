<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
//
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use DomainException;
use Exception;
use InvalidArgumentException;
use UnexpectedValueException;

class AuthFilter implements FilterInterface
{
    /**
     * Haga el procesamiento que este filtro debe hacer.
     * Por defecto, no debe devolver nada durante
     * Ejecución normal.Sin embargo, cuando un estado anormal
     * se encuentra, debe devolver una instancia de
     * CodeIgniter \ Http \ Respuesta.Si lo hace, script
     * La ejecución finalizará y esa respuesta será
     * Enviado de vuelta al cliente, permitiendo páginas de error,
     * redireccionamiento, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $response = service("response");
        $key = getenv("JWT_SECRET");
        /*
        $key = getenv("JWT_SECRET");
        $header = $request->getHeader("Authorization");
        $token = null;

        if (!empty($header)) {
            if (preg_match("/Bearer\s(\S+)/", $header, $matches)) {
                $token = $matches[1];
            }
        }

        if (is_null($token) || empty($token)) {
            $data=[
                "status"=>"faild",
                "code"=>404,
                "message"=>"in autorized"
            ];
            return $response->setJSON($data);
        }
        */
        try { 
            //--------------
            $authHeader = $request->getServer("HTTP_AUTHORIZATION");

           // if($authHeader == null) return $response->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED,"No se ha enviado el JWT");
            
            $explodeHeader = $authHeader ? explode(" ",$authHeader) : null;

            $token = $explodeHeader ? $explodeHeader[1] : "";

            //JWT::decode($token,$key,["HS256"]);

            //--------------
            JWT::decode($token, new Key($key, "HS256"));
            //return $response->setJSON(["test"=>"OK","token"=>$token[1]]);
            $data=[
                "status"=>"OK",
                "code"=>200,
                "message"=>"Éxito, se ha comprobado su identidad",
                "error"=>[]
            ];
            return $response->setStatusCode(ResponseInterface::HTTP_OK)->setJSON($data);

        }/*catch(Exception $e){
            return $response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR,"Ocurrio un error al tratar de validar el token")->setJSON(["status"=>500,"message"=>"token invalido"]);
        }*/
        
        catch (InvalidArgumentException $e) {
            $data=[
                "status"=>"fail",
                "code"=>405,
                "message"=>"Invalid token key",
                "error"=>$e->getMessage()
            ];
            $response->setStatusCode(404);
            return $response->setJSON($data);

        } catch (DomainException $e) {
            $data=[
                "status"=>"fail",
                "code"=>405,
                "message"=>"Invalid token key",
                "error"=>$e->getMessage()
            ];
            $response->setStatusCode(404);
            return $response->setJSON($data);
        } catch (SignatureInvalidException $e) {
            $data=[
                "status"=>"fail",
                "code"=>405,
                "message"=>"Invalid token key",
                "error"=>$e->getMessage()
            ];
            $response->setStatusCode(404);
            return $response->setJSON($data);
        } catch (BeforeValidException $e) {
            $data=[
                "status"=>"fail",
                "code"=>405,
                "message"=>"Invalid token key",
                "error"=>$e->getMessage()
            ];
            $response->setStatusCode(404);
            return $response->setJSON($data);
        } catch (ExpiredException $e) {
            $data=[
                "status"=>"fail",
                "code"=>405,
                "message"=>"Invalid token key",
                "error"=>$e->getMessage()
            ];
            $response->setStatusCode(404);
            return $response->setJSON($data);
        } catch (UnexpectedValueException $e) { //Vacio sin token 
            $data=[
                "status"=>"fail",
                "code"=>405,
                "message"=>"Invalid token key",
                "error"=>$e->getMessage()
            ];
            $response->setStatusCode(404);
            return $response->setJSON($data);
        }
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
