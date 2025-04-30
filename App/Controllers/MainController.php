<?php
namespace App\Controllers;

use BatAPI\Response;

class MainController
{
    public function index(): string
    {
        return Response::success(['message' => "I'm the GET night Controller."]);
    }
}