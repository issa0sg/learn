<?php

namespace Learn\Custom\Http\Routing;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Learn\Custom\Http\Exceptions\MethodNotAllowedException;
use Learn\Custom\Http\Exceptions\RouteNotFoundException;
use Learn\Custom\Http\Request;

use function FastRoute\simpleDispatcher;

class Router implements RouterInterface
{
    public function dispatch(Request $request)
    {
        [[$controller, $method], $vars] = $this->extractRouteInfo($request);

        return [[new $controller, $method], $vars];
    }

    private function extractRouteInfo(Request $request): array
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $collector) {
            $routes = include BASE_PATH.'/routes/web.php';

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
                throw new MethodNotAllowedException(sprintf('Allowed methods: %s', $allowedMethods));
            default:
                throw new RouteNotFoundException('Route not found');
        }
    }
}
