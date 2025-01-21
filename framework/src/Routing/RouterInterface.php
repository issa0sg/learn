<?php

namespace Learn\Custom\Routing;

use League\Container\Container;
use Learn\Custom\Http\Request;

interface RouterInterface
{
    public function dispatch(Request $request, Container $container);

    public function registerRoutes(array $routes);
}
