<?php

require_once 'vendor/autoload.php';

use BatAPI\App;
use BatAPI\Routing\Router;

App::bootstrap();

Router::get('/', function() {
    return 'test';
});

echo App::start();