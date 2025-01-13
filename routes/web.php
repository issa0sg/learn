<?php

use App\Controllers\FootballController;
use App\Controllers\HealthController;
use Learn\Custom\Http\Routing\Route;

return [
    Route::get('/__health', [HealthController::class, '__health']),
    Route::post('/football/{id:\d+}', [FootballController::class, 'getMatch']),
];
