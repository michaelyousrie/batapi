<?php

use App\Controllers\MainController;
use App\Middlewares\PostHandler\LogIncomingRequest;
use App\Middlewares\PreHandler\AttachUniqueIdForIncomingRequest;
use App\Middlewares\PreHandler\RateLimiter;
use BatAPI\Routing\Router;

Router::get('/', [MainController::class, 'index'])
    ->preHandlerMiddlewares([
        new RateLimiter(100),
        new AttachUniqueIdForIncomingRequest(),
    ])
    ->postHandlerMiddlewares([
        new LogIncomingRequest()
    ]);