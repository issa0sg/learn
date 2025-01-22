<?php

namespace App\Services;

class Healthcheck
{
    public function getHealth(): string
    {
        return 'Healthy ok 1080%';
    }
}
