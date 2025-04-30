<?php

require_once '../vendor/autoload.php';

use BatAPI\App;

App::bootstrap();

require_once "../app/routes.php";

echo App::start();