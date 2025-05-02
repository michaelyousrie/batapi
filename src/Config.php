<?php

namespace BatAPI;

abstract class Config
{
    //  =========================== PARAMS ===========================
    private static array $configs = [];

    //  =========================== PUBLIC METHODS ===========================
    /**
     * Fetches a config value.
     *
     * @param string $key
     * @param mixed $fallback The default that should be returned if the config key doesn't exist.
     * @return mixed
     */
    public static function get(string $key, mixed $fallback = null): mixed
    {
        return self::$configs[$key] ?? $fallback;
    }

    /**
     * Sets a config value
     *
     * @param string $key
     * @param mixed $value
     * @return mixed The config value that was just set.
     */
    public static function set(string $key, mixed $value): mixed
    {
        self::$configs[$key] = $value;

        return self::get($key);
    }

    //  =========================== INTERNAL METHODS ===========================
}