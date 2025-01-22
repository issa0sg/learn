<?php

namespace Learn\Custom\Http;

class Response
{
    public function __construct(
        private mixed $content = '',
        private readonly int $statusCode = 200,
        private array $headers = []
    ) {
        http_response_code($this->statusCode);
    }

    public function send()
    {
        echo $this->content;
    }

    public function setContent(mixed $content): void
    {
        $this->content = $content;
    }
}
