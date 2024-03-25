<?php

require '../helpers.php';

//autoloading all the classes under Framework instead of requiring them individually
$autoLoadClass = function ($class) {
    $path = basePath('Framework/' . $class . '.php');
    if (file_exists($path)) {
        require $path;
    }
};
spl_autoload_register($autoLoadClass);

//Instantiating Router
$router = new Router();

//Get routes
$routes = require basePath('routes.php');

//Get current uri and method
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

//Route the request
$router->route($uri, $method);
