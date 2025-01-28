<?php

namespace Learn\Custom\Controller;

use Learn\Custom\Http\Response;
use Psr\Container\ContainerInterface;

abstract class AbstractController
{
    protected ?ContainerInterface $container = null;

    public function setContainer(ContainerInterface $container): void
    {
        $this->container = $container;
    }

    public function render(string $view, array $data = [], ?Response $response = null): Response
    {
        $twig = $this->container->get('twig');

        $content = $twig->render($view, $data);

        $response ??= new Response;

        $response->setContent($content);

        return $response;
    }
}
