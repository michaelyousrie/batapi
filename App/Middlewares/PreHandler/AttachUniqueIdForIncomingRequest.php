<?php

namespace App\Middlewares\PreHandler;

use BatAPI\Interfaces\Middleware\PreHandlerMiddleware;
use BatAPI\Request;
use BatAPI\Utils\Hasher;

class AttachUniqueIdForIncomingRequest extends PreHandlerMiddleware
{
    public function handle()
    {
        Request::custom('id', Hasher::unique('request_'));
    }
}