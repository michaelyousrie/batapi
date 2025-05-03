<?php

namespace BatAPI\Interfaces\Middleware;

abstract class PreHandlerMiddleware extends Middleware
{
    abstract public function handle();
}