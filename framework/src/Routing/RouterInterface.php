<?php

namespace Learn\Custom\Routing;

use Learn\Custom\Http\Request;

interface RouterInterface
{
    public function dispatch(Request $request);

    public function registerRoutes(array $routes);
}
