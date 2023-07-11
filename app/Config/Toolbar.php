<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Debug\Toolbar\Collectors\Database;
use CodeIgniter\Debug\Toolbar\Collectors\Events;
use CodeIgniter\Debug\Toolbar\Collectors\Files;
use CodeIgniter\Debug\Toolbar\Collectors\Logs;
use CodeIgniter\Debug\Toolbar\Collectors\Routes;
use CodeIgniter\Debug\Toolbar\Collectors\Timers;
use CodeIgniter\Debug\Toolbar\Collectors\Views;
use CodeIgniter\Debug\Toolbar\Collectors\Cache;

/**
 * --------------------------------------------------------------------------
 * Debug Toolbar
 * --------------------------------------------------------------------------
 *
 * The Debug Toolbar provides a way to see information about the performance
 * and state of your application during that page display. By default it will
 * NOT be displayed under production environments, and will only display if
 * `CI_DEBUG` is true, since if it's not, there's not much to display anyway.
 */
class Toolbar extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * Toolbar Collectors
     * --------------------------------------------------------------------------
     *
     *Lista de coleccionistas de barras de herramientas que se llamarán cuando la barra de herramientas de depuración
     * Acumula y recopila datos de.
     *
     * @var string[]
     */
    public array $collectors = [
        /*Timers::class,
        Database::class,
        Logs::class,
        Views::class,
        //Cache::class, //
        Files::class,
        Routes::class,
        Events::class,*/
    ];

    /**
     * --------------------------------------------------------------------------
     * Collect Var Data
     * --------------------------------------------------------------------------
     *
     * Si se establecen en False VAR, los datos de las vistas no se colocarán.Útil para
     * Evite el alto uso de la memoria cuando hay muchos datos pasados a la vista.
     */
    public bool $collectVarData = false;
    //public bool $collectVarData = true;

    /**
     * --------------------------------------------------------------------------
     * Max History
     * --------------------------------------------------------------------------
     *
     *`$ maxhistory` establece un límite en la cantidad de solicitudes pasadas que se almacenan,
     * Ayuda a conservar el espacio de archivos utilizado para almacenarlos.Puedes configurarlo en
     * 0 (cero) para no tener ningún historial almacenado, o -1 para historia ilimitada.
     */
    public int $maxHistory = 20;

    /**
     * --------------------------------------------------------------------------
     * Toolbar Views Path
     * --------------------------------------------------------------------------
     *
     * El camino completo a las vistas que utilizan la barra de herramientas.
     * Esto debe tener una barra de corte.
     */
    public string $viewsPath = SYSTEMPATH . 'Debug/Toolbar/Views/';

    /**
     * --------------------------------------------------------------------------
     * Max Queries
     * --------------------------------------------------------------------------
     *
     *Si el recopilador de la base de datos está habilitado, registrará cada consulta que el
     * El sistema genera para que se puedan mostrar en la línea de tiempo de la barra de herramientas
     * Y en el registro de consultas.Esto puede conducir a problemas de memoria en algunos casos
     * Con cientos de consultas.
     *
     * `$ Maxqueries` define la cantidad máxima de consultas que se almacenarán.
     */
    public int $maxQueries = 100;
}
