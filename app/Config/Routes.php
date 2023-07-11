<?php

namespace Config;
// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

//Url views
$routes->get('/', 'Home::index');
//$routes->get("confirmar_registro/(:hash)","UsuarioController::ConfirmarCuenta/$1");
$routes->match(["get","post"],"confirmar_registro/(:any)","UsuarioController::ConfirmarCuenta/$1");
$routes->get("document/css","DocumentController::CSS");
/*
$routes->get('/vendedor', 'Home::index');
$routes->get('/admin', 'Home::index');
$routes->get('/recuperarpasword/:any', 'Home::index');
$routes->get('/confirmarregistro/:any', 'Home::index');
$routes->get('/', 'Home::index');*/

//Url API's
$routes->group("api",static function($routes){
    //Autenticacion
    $routes->group("authentication", static function($routes){
        $routes->post("login","UsuarioController::Login");
        $routes->post("signup","UsuarioController::Signup");
        $routes->get("logout","UsuarioController::Logout");
    });
    


    //Usuario
    $routes->group("usuario",["filter"=>"authFilter"],static function($routes){                
        //$routes->post("addCar","UserController::post");
        //$routes->post("removeCar/:num","UserController::post");
        //$routes->post("getCar","UserController::post");
        //$routes->post("getCar/:num","UserController::post");
        //$routes->post("pay/:num","UserController::post");
        //$routes->post("update/:any","UserController::post");
        //$routes->get("/","UsuarioController::Logout");
        $routes->get("/","UsuarioController::Test");
    });
});



//$routes->gro

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
