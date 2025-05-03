<?php

namespace BatAPI\Utils;

abstract class DateTime
{
    public static function inFormat(string $format): string
    {
        return date($format);
    }

    public static function now(): string
    {
        return self::inFormat('Y-m-d H:i:s');
    }

    public static function time(): string
    {
        return self::inFormat('H:i:s');
    }

    public static function date(): string
    {
        return self::inFormat('Y-m-d');
    }
}