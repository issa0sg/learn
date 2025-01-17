<?php

namespace Learn\Custom\Http;

use Learn\Custom\Http\Exceptions\HttpException;
use Learn\Custom\Routing\RouterInterface;
use Throwable;

class Kernel
{
    public function __construct(
        private readonly RouterInterface $router,
    ) {}

    public function handle(Request $request): Response
    {
        try {
            [$routeHandler, $vars] = $this->router->dispatch($request);
            $response = call_user_func_array($routeHandler, $vars);
        } catch (HttpException $e) {
            $response = new Response($e->getMessage(), $e->getHttpCode());
        } catch (Throwable $e) {
            $response = new Response($e->getMessage(), 500);
        }

        return $response;
    }
}
