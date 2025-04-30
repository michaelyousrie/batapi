<?php

use BatAPI\Response;
use BatAPI\Routing\Router;
use App\Controllers\MainController;

Router::get('/', [MainController::class, 'index']);
Router::get('/closure', fn() => Response::success(['message' => 'I am the night. From Closure.']));