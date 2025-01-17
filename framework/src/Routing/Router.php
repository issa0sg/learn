<?php

namespace Learn\Custom\Routing;

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
        [$handler, $vars] = $this->extractRouteInfo($request);

        if (is_array($handler)) {
            [$controller, $method] = $handler;
            $handler = [new $controller, $method];
        }

        return [$handler, $vars];
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
