<?php

use App\Controllers\FootballController;
use App\Controllers\HealthController;
use Learn\Custom\Routing\Route;

return [
    Route::get('/__health', [HealthController::class, '__health']),
    Route::post('/football/{id:\d+}', [FootballController::class, 'getMatch']),
    Route::get('/football/team/{teamName}', function (string $teamName) {
        return new \Learn\Custom\Http\Response('this team name: '.$teamName);
    }),
];
