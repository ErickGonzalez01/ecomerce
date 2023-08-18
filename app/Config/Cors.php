<?php

namespace Config;


/**
 * --------------------------------------------------------------------------
 * Cross-Origin Resource Sharing (CORS) Configuration
 * --------------------------------------------------------------------------
 *
 * Here you may configure your settings for cross-origin resource sharing
 * or "CORS". This determines what cross-origin operations may execute
 * in web browsers. You are free to adjust these settings as needed.
 *
 * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
 */
class Cors extends \Fluent\Cors\Config\Cors
{
    /**
     * --------------------------------------------------------------------------
     * Allowed HTTP headers
     * --------------------------------------------------------------------------
     *
     * Indicates which HTTP headers are allowed.
     *
     * @var array
     */
    public $allowedHeaders = ['*'];

    /**
     * --------------------------------------------------------------------------
     * Allowed HTTP methods
     * --------------------------------------------------------------------------
     *
     * Indicates which HTTP methods are allowed.
     *
     * @var array
     */
    public $allowedMethods = ['*']; //[*]

    /**
     * --------------------------------------------------------------------------
     * Allowed request origins
     * --------------------------------------------------------------------------
     *
     * Indicates which origins are allowed to perform requests.
     * Patterns also accepted, for example *.foo.com
     *
     * @var array
     */
    public $allowedOrigins = ['*'];

    /**
     * --------------------------------------------------------------------------
     * Allowed origins patterns
     * --------------------------------------------------------------------------
     *
     * Patterns that can be used with `preg_match` to match the origin.
     *
     * @var array
     */
    public $allowedOriginsPatterns = [];

    /**
     * --------------------------------------------------------------------------
     * Exposed headers
     * --------------------------------------------------------------------------
     *
     * Encabezados que pueden estar expuestos al servidor web.
     *
     * @var array
     */
    public $exposedHeaders = []; //[]

    /**
     * --------------------------------------------------------------------------
     * Max age
     * --------------------------------------------------------------------------
     *
     * Indica cuánto tiempo se pueden almacenar en caché los resultados de una solicitud previa al vuelo.
     *
     * @var int
     */
    public $maxAge = 0; //0

    /**
     * --------------------------------------------------------------------------
     * Whether or not the response can be exposed when credentials are present
     * --------------------------------------------------------------------------
     *
     * Indica si la respuesta a la solicitud puede expuestos o no cuando el
     * La bandera de credenciales es verdadera.Cuando se usa como parte de una respuesta a un prever
     * Solicitud, esto indica si la solicitud real se puede hacer o no
     * Uso de credenciales.Tenga en cuenta que las solicitudes de Get Simple no están preferidas,
     * Y así, si se realiza una solicitud para un recurso con credenciales, si
     * Este encabezado no se devuelve con el recurso, la respuesta
     * es ignorado por el navegador y no se devuelve al contenido web.
     *
     * @var boolean
     */
    public $supportsCredentials = false; //false
}
