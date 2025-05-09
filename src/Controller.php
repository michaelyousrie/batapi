<?php
namespace BatAPI;

use function BatAPI\Utils\dd;

abstract class Controller
{
    public static function determine(array $identifier): string
    {
        if (!($identifier['0'] ?? false) or !($identifier[1] ?? false)) {
            dd("Invalid callable controller identifier. The identifier should be passed as an array with the firest element being the full class name, the second element being the method name as a string.");
        }

        $class = new $identifier[0];

        return $class->{$identifier[1]}();
    }
}