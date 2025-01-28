<?php

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Tools\DsnParser;
use League\Container\Argument\Literal\StringArgument;
use League\Container\Container;
use League\Container\ReflectionContainer;
use Learn\Custom\Console\Application;
use Learn\Custom\Console\Kernel as ConsoleKernel;
use Learn\Custom\Controller\AbstractController;
use Learn\Custom\Dbal\ConnectionFactory;
use Learn\Custom\Http\Kernel;
use Learn\Custom\Routing\Router;
use Learn\Custom\Routing\RouterInterface;
use Symfony\Component\Dotenv\Dotenv as DotenvAlias;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$routes = include BASE_PATH.'/routes/web.php';
$viewsPath = BASE_PATH.'/views';
$dbUrl = 'pdo-mysql://appuser:Aa1234@db/app-learn-database';

$dotent = new DotenvAlias;
$dotent->load(BASE_PATH.'/.env');

$container = new Container;

$container->delegate(new ReflectionContainer);

$container->add('framework-commands-namespace', new StringArgument('Learn\\Custom\\Console\\Commands\\'));

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

$container->add(ConnectionFactory::class)
    ->addArgument(new StringArgument($dbUrl))
    ->addArgument(DsnParser::class);

$container->addShared(Connection::class, function () use ($container): Connection {
    return $container->get(ConnectionFactory::class)->create();
});

$container->add(ConsoleKernel::class)
    ->addArgument($container)
    ->addArgument(Application::class);

$container->add(Application::class)->addArgument($container);

return $container;
