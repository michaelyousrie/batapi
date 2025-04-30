<?php
namespace BatAPI;

use BatAPI\Interfaces\Bootstrappable;

class App implements Bootstrappable
{
    private static array $configs = [];

    /**
     * Bootstraps a few components of the application to activate all the gears.
     *
     * @return void
     */
    public static function bootstrap(): void
    {
        session_start();
        Request::bootstrap();

        self::config('APP_NAME', 'New Bat API Applications');
    }

    /**
     * Sets or gets a config value.
     * Config values are shared across the entire application.
     *
     * @param string $key The string identifier for the config value.
     * @param mixed $value The config value.
     * @return mixed
     */
    public static function config(string $key, mixed $value = null): mixed
    {
        if (is_null($value)) {
            return self::getConfig($key);
        }

        return self::setConfig($key, $value);
    }

    /**
     * Fetches a config value.
     *
     * @param string $key
     * @param mixed $fallback The default that should be returned if the config key doesn't exist.
     * @return mixed
     */
    public static function getConfig(string $key, mixed $fallback = null): mixed
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
    public static function setConfig(string $key, mixed $value): mixed
    {
        self::$configs[$key] = $value;

        return self::getConfig($key);
    }

    /**
     * Start handling requests. Should return the final response to the user.
     *
     * @return string
     */
    public static function start()
    {
        //
    }
}