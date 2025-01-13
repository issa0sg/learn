<?php

namespace App\Controllers;

use Learn\Custom\Http\Response;

class FootballController
{
    public function getMatch(int $id)
    {
        $content = sprintf('<h1>Football resulted %s</h1>', $id);

        return new Response($content);

    }
}
