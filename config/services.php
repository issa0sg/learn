<?php

use League\Container\Argument\Literal\StringArgument;
use League\Container\Container;
use League\Container\ReflectionContainer;
use Learn\Custom\Http\Kernel;
use Learn\Custom\Routing\Router;
use Learn\Custom\Routing\RouterInterface;
use Symfony\Component\Dotenv\Dotenv as DotenvAlias;

$routes = include BASE_PATH.'/routes/web.php';

$dotent = new DotenvAlias();
$dotent->load(BASE_PATH . '/.env');

$container = new Container;

$container->delegate(new ReflectionContainer);

$container->add('APP_ENV', new StringArgument($_ENV['APP_ENV'] ?? 'production'));

$container->add(RouterInterface::class, Router::class);

$container->extend(RouterInterface::class)->addMethodCall('registerRoutes', ['routes' => $routes]);

$container->add(Kernel::class)
    ->addArgument(RouterInterface::class)
    ->addArgument($container);

return $container;
