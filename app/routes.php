<?php

use BatAPI\Response;
use BatAPI\Routing\Router;
use App\Controllers\MainController;

Router::get('/', [MainController::class, 'index']);
Router::post('/', fn() => Response::success(['message' => 'I am the Post night. From Closure.']));