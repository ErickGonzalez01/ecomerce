<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;
use App\Filters\AuthFilter;
use \Fluent\Cors\Filters\CorsFilter;

class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     */
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        "authFilter"    => AuthFilter::class,
        "cors"          => CorsFilter::class
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     */
    public array $globals = [
        'before' => [
            // 'honeypot',
            'csrf'=>["except"=>["api/*"]],
            // 'invalidchars',
        ],
        'after' => [
            //'toolbar',
            // 'honeypot',
            // 'secureheaders',
        ],
    ];

    /**
     * Lista de alias de filtro que funciona en un
     * Método HTTP particular (obtener, post, etc.).
     *
     * Example:
     * 'post' => ['foo', 'bar']
     *
     * Si usa esto, debe deshabilitar la ruta automática porque la ruta automática
     * Permite cualquier método HTTP para acceder a un controlador.Acceder al controlador
     * Con un método que no espera podría evitar el filtro.
     */
    public array $methods = [];

    /**
     * Lista de alias de filtro que deben ejecutarse en cualquier
     * Antes o después de los patrones URI.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     */
    public array $filters = [
        "cors"          => ["before"     =>["api/*"]],
        "authFilter"    => ["before"     =>["api/usuario/*"]]
    ];
}
