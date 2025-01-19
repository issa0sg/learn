<?php

namespace App;

class Healthcheck
{
    public function __construct(int $value) {}

    public function getHealth(): string
    {
        return 'Healthy ok 100%';
    }
}
