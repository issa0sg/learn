<?php

namespace Learn\Custom\Http;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;

use function FastRoute\simpleDispatcher;

class Kernel
{
    public function handle(Request $request): Response
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $collector) {

            $routes = include BASE_PATH.'/routes/web.php';

            foreach ($routes as $route) {
                $collector->addRoute(...$route);
            }
        });

        $routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getUri());

        if ($routeInfo[0] === Dispatcher::NOT_FOUND) {
            return new Response('Not found', 404);
        }

        [$statusCode, [$controller, $method], $vars] = $routeInfo;

        return call_user_func_array([new $controller, $method], $vars);
    }
}
