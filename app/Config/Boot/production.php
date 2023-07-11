<?php

/*
 |--------------------------------------------------------------------------
 | ERROR DISPLAY
 |--------------------------------------------------------------------------
 | Don't show ANY in production environments. Instead, let the system catch
 | it and display a generic error message.
 */
ini_set('display_errors', '0');
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);

/*
 |--------------------------------------------------------------------------
 | DEBUG MODE
 |--------------------------------------------------------------------------
 | El modo de depuración es una bandera experimental que puede permitir cambios en todo momento
 |el sistema.No se usa ampliamente actualmente y puede no sobrevivir
 |Liberación del marco.
 */
defined('CI_DEBUG') || define('CI_DEBUG', false);
