<?php
session_start();

require dirname(__DIR__) . '/App/Constants.php';
require dirname(__DIR__) . '/App/Functions.php';

require dirname(__DIR__) . '/vendor/autoload.php';


error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');


/**
 * Routing
 */
$router = new Core\Router();
// Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('edit', ['controller' => 'Home', 'action' => 'edit']);
$router->add('install', ['controller' => 'Install', 'action' => 'index']);
$router->add('uninstall', ['controller' => 'Uninstall', 'action' => 'index']);
$router->add('app', ['controller' => 'B24Frame', 'action' => 'index']);
$router->add('wawe', ['controller' => 'WaweConnect', 'action' => 'index']);
$router->add('waweDisconect', ['controller' => 'WaweDisconect', 'action' => 'index']);
$router->add('{controller}/{action}');
    
$router->dispatch($_SERVER['QUERY_STRING']);
