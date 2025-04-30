<?php
namespace BatAPI\Utils;

use BatAPI\Response;

class Debugger
{
    /**
     * Debug an array of values. The response will be sent as JSON with status code 500.
     *
     * @param array $debuggables
     * @return string
     */
    public static function dd(array $debuggables): string
    {
        return Response::debug($debuggables);
    }
}