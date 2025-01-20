<?php

use League\Container\Argument\Literal\ArrayArgument;
use League\Container\Container;
use Learn\Custom\Http\Kernel;
use Learn\Custom\Routing\Router;
use Learn\Custom\Routing\RouterInterface;

$routes = include BASE_PATH . '/routes/web.php';

$container = new Container();

$container->add(RouterInterface::class, Router::class);

$container->extend(RouterInterface::class)->addMethodCall('registerRoutes', ['routes' => $routes]);

$container->add(Kernel::class)
    ->addArgument(RouterInterface::class);

return $container;
