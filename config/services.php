<?php

use League\Container\Argument\Literal\StringArgument;
use League\Container\Container;
use League\Container\ReflectionContainer;
use Learn\Custom\Controller\AbstractController;
use Learn\Custom\Http\Kernel;
use Learn\Custom\Routing\Router;
use Learn\Custom\Routing\RouterInterface;
use Symfony\Component\Dotenv\Dotenv as DotenvAlias;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$routes = include BASE_PATH . '/routes/web.php';
$viewsPath = BASE_PATH . '/views';

$dotent = new DotenvAlias();
$dotent->load(BASE_PATH . '/.env');

$connectionParams = [
    'dbname' => 'app-learn-database',
    'user' => 'appuser',
    'password' => 'Aa1234',
    'host' => 'db',
    'driver' => 'pdo_mysql',
];

$conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams);
$conn->getServerVersion();

$container = new Container;

$container->delegate(new ReflectionContainer);

$container->add('APP_ENV', new StringArgument($_ENV['APP_ENV'] ?? 'production'));

$container->add(RouterInterface::class, Router::class);

$container->extend(RouterInterface::class)->addMethodCall('registerRoutes', ['routes' => $routes]);

$container->add(Kernel::class)
    ->addArgument(RouterInterface::class)
    ->addArgument($container);

$container->addShared('twig-loader', FilesystemLoader::class)
    ->addArgument(new StringArgument($viewsPath));

$container->addShared('twig', Environment::class)
    ->addArgument('twig-loader');

$container->inflector(AbstractController::class)
    ->invokeMethod('setContainer', [$container]);

return $container;
