<?php

use App\Controllers\MainController;
use BatAPI\Routing\Router;

Router::get('/', [MainController::class, 'index']);