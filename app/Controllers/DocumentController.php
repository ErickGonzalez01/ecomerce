<?php namespace App\Controllers;

use App\Controllers\BaseController;

class DocumentController extends BaseController
{
    public function CSS()
    {   
        $rutaArchivo = APPPATH . 'views\Autenticacion\estilos_confirmar_registros.css';
        // Verifica si el archivo existe
        if (file_exists($rutaArchivo)) {
            // Establece el contenido del archivo CSS
            $contenido = file_get_contents($rutaArchivo);
            // Establece el encabezado de la respuesta como CSS
            $this->response->setHeader('Content-Type', 'text/css');
            // Establece el contenido del archivo CSS como cuerpo de la respuesta
            $this->response->setBody($contenido);
            // Devuelve la respuesta
            return $this->response;
        } else {
            // Archivo no encontrado, puedes devolver un mensaje de error o redireccionar a otra página
            return;
        }
    }
}
