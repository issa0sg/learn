<?php

namespace Learn\Custom\Http\Exceptions;

class HttpException extends \Exception
{
    protected int $httpCode = 500;

    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    public function setHttpCode(int $httpCode): void
    {
        $this->httpCode = $httpCode;
    }
}
