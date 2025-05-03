<?php

namespace BatAPI;

abstract class Config
{

    private static array $configs = [];


    public static function get(string $key, mixed $fallback = null): mixed
    {
        return self::$configs[$key] ?? $fallback;
    }

    public static function set(string $key, mixed $value): mixed
    {
        self::$configs[$key] = $value;

        return self::get($key);
    }
}