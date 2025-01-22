<?php

namespace App\Controllers;

use App\Services\Healthcheck;
use Learn\Custom\Controller\AbstractController;
use Learn\Custom\Http\Response;

class HealthController extends AbstractController
{
    public function __construct(
        protected Healthcheck $healthcheck,
    ) {}

    public function __health(): Response
    {
        $message = $this->healthcheck->getHealth();

        return $this->render('health.html.twig', ['message' => $message]);
    }
}
