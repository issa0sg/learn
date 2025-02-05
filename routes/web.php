<?php

use App\Controllers\FootballController;
use App\Controllers\HealthController;
use App\Controllers\PostController;
use Learn\Custom\Routing\Route;

return [
    Route::get('/__health', [HealthController::class, '__health']),
    Route::get('/posts/{id:\d+}', [PostController::class, 'index']),
    Route::get('/posts/create', [PostController::class, 'create']),
    Route::post('/posts', [PostController::class, 'store']),
    Route::get('/football/{id:\d+}', [FootballController::class, 'getMatch']),
    Route::get('/football/team/{teamName}', function (string $teamName) {
        return new \Learn\Custom\Http\Response('this team name: '.$teamName);
    }),
];
