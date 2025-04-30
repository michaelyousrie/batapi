<?php

require_once '../vendor/autoload.php';

use BatAPI\App;

App::bootstrap();

require_once "../App/Routes.php";

echo App::start();