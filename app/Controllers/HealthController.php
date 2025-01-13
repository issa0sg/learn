<?php

namespace App\Controllers;

use Learn\Custom\Http\Response;

class HealthController
{
    public function __health(): Response
    {
        $content = '<h1>health ok</h1>';

        return new Response($content);
    }
}
