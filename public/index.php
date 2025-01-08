<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use App\Healthcheck;

$healtchecker = new Healthcheck();

$healtchecker->getHealth();

dd("Hello");