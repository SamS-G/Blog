<?php

    use App\config\Router;

    define('ROOT', dirname(__DIR__));

    require_once ROOT . '/vendor/autoload.php';
    require_once ROOT . '/config/dev.php';


    session_start();
    $router = new Router;
    $router->startRouter();