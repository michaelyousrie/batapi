<?php

use App\Controllers\MainController;
use App\Middlewares\LogIncomingRequest;
use BatAPI\Routing\Router;

Router::get('/', [MainController::class, 'index'])
    ->middlewares([LogIncomingRequest::class]);