<?php

use BatAPI\Response;
use BatAPI\Routing\Router;

Router::get('/', fn() => Response::success(['hello' => 'world!']));