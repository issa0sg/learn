<?php

namespace App\Controllers;

use Learn\Custom\Controller\AbstractController;

class FootballController extends AbstractController
{
    public function getMatch(int $id)
    {
        return $this->render('get_match.html.twig', ['id' => $id]);
    }
}
