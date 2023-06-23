<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\Response;

class DocumentController extends BaseController
{
    /*public function CSS($name)
    {
        return;
    }*/

    public function CSS($nombreArchivo)
    {
        // Obtén el nombre del archivo CSS desde los parámetros de la URL o como desees
        //$nombreArchivo = $this->request->uri->getSegment(3);

        // Establece la ruta completa al archivo CSS
        $rutaArchivo = WRITEPATH . 'app/view'. $nombreArchivo;

        // Verifica si el archivo existe
        if (file_exists($rutaArchivo)) {
            // Crea una instancia de la clase Response
            $response = new Response();

            // Establece el contenido del archivo CSS
            $contenido = file_get_contents($rutaArchivo);

            // Establece el encabezado de la respuesta como CSS
            $response->setHeader('Content-Type', 'text/css');

            // Establece el contenido del archivo CSS como cuerpo de la respuesta
            $response->setBody($contenido);

            // Devuelve la respuesta
            return $response;
        } else {
            // Archivo no encontrado, puedes devolver un mensaje de error o redireccionar a otra página
            return 'Archivo no encontrado';
        }
    }
}
