<?php

use App\Controllers\MainController;
use BatAPI\Response;
use BatAPI\Routing\Router;

Router::get('/', [MainController::class, 'index']);
Router::post('/', fn() => Response::success(['message' => 'I am the Post night. From Closure.']));