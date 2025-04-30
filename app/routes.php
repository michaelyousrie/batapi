<?php

use BatAPI\Response;
use BatAPI\Routing\Router;

Router::get('/test/', fn() => Response::success(['data' => 'Hello!']));

Router::post('/', fn() => Response::success(['msg' => 'Posted Successfully']));