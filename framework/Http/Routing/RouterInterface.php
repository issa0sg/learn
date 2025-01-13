<?php

namespace Learn\Custom\Http\Routing;

use Learn\Custom\Http\Request;

interface RouterInterface
{
    public function dispatch(Request $request);
}
