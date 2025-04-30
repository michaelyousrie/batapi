<?php
namespace App\Controllers;

use BatAPI\Response;

class MainController
{
    public function index()
    {
        return Response::success(['message' => "I'm the night Controller."]);
    }
}