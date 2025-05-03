<?php

use App\Controllers\MainController;
use App\Middlewares\PostHandler\LogIncomingRequest;
use App\Middlewares\PreHandler\AttachUniqueIdForIncomingRequest;
use BatAPI\Routing\Router;

Router::get('/', [MainController::class, 'index'])
    ->preHandlerMiddlewares([AttachUniqueIdForIncomingRequest::class])
    ->postHandlerMiddlewares([LogIncomingRequest::class]);