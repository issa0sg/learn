<?php

use Learn\Custom\Http\Kernel;
use Learn\Custom\Http\Request;

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH.'/vendor/autoload.php';

/** @var \League\Container\Container $container */
$container = require BASE_PATH . '/config/services.php';

$request = Request::createFromGlobals();

$response = $container->get(Kernel::class)->handle($request);

$response->send();
