<?php

use Learn\Custom\Http\Request;

require_once dirname(__DIR__).'/vendor/autoload.php';

$request = Request::createFromGlobals();

dd($request);