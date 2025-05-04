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

    public static function nowHour(): int
    {
        return (int) date('H');
    }

    public static function nowMinute(): int
    {
        return (int) date('i');
    }

    public static function nowSecond(): int
    {
        return (int) date('s');
    }

    public static function nowDay(): int
    {
        return (int) date('d');
    }

    public static function nowMonth(): string
    {
        return self::inFormat('m');
    }

    public static function nowYear(): string
    {
        return self::inFormat('Y');
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