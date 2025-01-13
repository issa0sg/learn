<?php

namespace App;

class Healthcheck
{
    public function getHealth(): string
    {
        return 'Healthy ok 100%';
    }
}
