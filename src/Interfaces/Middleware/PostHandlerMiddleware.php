<?php

namespace BatAPI\Interfaces\Middleware;

abstract class PostHandlerMiddleware extends Middleware
{
    abstract public function handle(string $response);
}