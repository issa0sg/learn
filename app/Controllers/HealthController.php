<?php

namespace App\Controllers;

use App\Services\Healthcheck;
use Learn\Custom\Http\Response;

class HealthController
{
    public function __construct(
        protected Healthcheck $healthcheck
    ) {}

    public function __health(): Response
    {
        $msg = $this->healthcheck->getHealth();
        $content = "<h1>$msg</h1>";

        return new Response($content);
    }
}
