<?php

namespace Learn\Custom\Routing;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Learn\Custom\Http\Exceptions\MethodNotAllowedException;
use Learn\Custom\Http\Exceptions\RouteNotFoundException;
use Learn\Custom\Http\Request;
use Psr\Container\ContainerInterface;

use function FastRoute\simpleDispatcher;

class Router implements RouterInterface
{
    private array $routes = [];

    public function dispatch(Request $request, ContainerInterface $container)
    {
        [$handler, $vars] = $this->extractRouteInfo($request);

        if (is_array($handler)) {
            [$controllerId, $method] = $handler;
            $controller = $container->get($controllerId);
            $handler = [$controller, $method];
        }

        return [$handler, $vars];
    }

    public function registerRoutes(array $routes)
    {
        $this->routes = array_merge($this->routes, $routes);
    }

    private function extractRouteInfo(Request $request): array
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $collector) {
            $routes = $this->routes;

            foreach ($routes as $route) {
                $collector->addRoute(...$route);
            }
        });

        $routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getUri());

        switch ($routeInfo[0]) {
            case Dispatcher::FOUND:
                return [$routeInfo[1], $routeInfo[2]];
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = implode(', ', $routeInfo[1]);
                $e = new MethodNotAllowedException(sprintf('Allowed methods: %s', $allowedMethods));
                $e->setHttpCode(405);
                throw $e;
            default:
                $e = new RouteNotFoundException('Route not found');
                $e->setHttpCode(404);
                throw $e;
        }
    }
}
