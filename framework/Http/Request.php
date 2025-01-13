<?php

namespace Learn\Custom\Http;

readonly class Request
{
    public function __construct(
        private array $getParams,
        private array $postData,
        private array $cookies,
        private array $files,
        private array $serverParams,
    ) {}

    public static function createFromGlobals(): static
    {
        return new static(
            $_GET,
            $_POST,
            $_COOKIE,
            $_FILES,
            $_SERVER,
        );
    }

    public function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getUri(): string
    {
        return explode('?', $_SERVER['REQUEST_URI'])[0];
    }
}
