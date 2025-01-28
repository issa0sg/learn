<?php

namespace Learn\Custom\Http;

use Exception;
use League\Container\Container;
use Learn\Custom\Http\Exceptions\HttpException;
use Learn\Custom\Routing\RouterInterface;

class Kernel
{
    private string $environment = 'development';

    public function __construct(
        private readonly RouterInterface $router,
        private readonly Container $container,
    ) {
        $this->environment = $this->container->get('APP_ENV');
    }

    public function handle(Request $request): Response
    {
        try {
            [$routeHandler, $vars] = $this->router->dispatch($request, $this->container);
            $response = call_user_func_array($routeHandler, $vars);
        } catch (Exception $e) {
            $response = $this->handleExceptionResponse($e);
        }

        return $response;
    }

    protected function handleExceptionResponse(Exception $e)
    {
        if ($this->environment !== 'production') {
            throw $e;
        }

        if ($e instanceof HttpException) {
            return new Response($e->getMessage(), $e->getHttpCode());
        }

        return new Response('Server internal error', 500);
    }
}
