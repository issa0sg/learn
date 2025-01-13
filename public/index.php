<?php

use Learn\Custom\Http\Kernel;
use Learn\Custom\Http\Request;
use Learn\Custom\Http\Routing\Router;

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH.'/vendor/autoload.php';

$request = Request::createFromGlobals();

$router = new Router;

$kernel = new Kernel($router);

$response = $kernel->handle($request);

$response->send();
