<?php

require_once '../vendor/autoload.php';

use BatAPI\App;
use BatAPI\Routing\Router;

App::bootstrap();

require_once "../app/routes.php";

echo App::start();