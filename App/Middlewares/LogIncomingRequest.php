<?php

namespace App\Middlewares;

use BatAPI\Interfaces\Middleware;
use BatAPI\Logger;
use BatAPI\Request;

class LogIncomingRequest extends Middleware
{
    public function handle()
    {
        Logger::dailyFile('incoming_requests', [
            'method'    => Request::method(),
            'url'       => Request::uri(),
            'data'      => Request::data(),
        ]);
    }
}