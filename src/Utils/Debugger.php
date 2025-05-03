<?php
namespace BatAPI\Utils;

use BatAPI\Response;

class Debugger
{
    public static function dd(array $debuggables): string
    {
        return Response::debug($debuggables);
    }
}