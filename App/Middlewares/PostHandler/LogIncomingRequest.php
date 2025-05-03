<?php

namespace App\Middlewares\PostHandler;

use BatAPI\Interfaces\Middleware\PostHandlerMiddleware;
use BatAPI\Logger;
use BatAPI\Request;

class LogIncomingRequest extends PostHandlerMiddleware
{
    public function handle(string $response)
    {
        Logger::dailyFile('incoming_requests', [
            'ID'        => Request::custom('id'),
            'method'    => Request::method(),
            'url'       => Request::uri(),
            'data'      => Request::data(),
            'response'  => $response,
        ]);
    }
}