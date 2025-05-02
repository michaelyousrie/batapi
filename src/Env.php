<?php

namespace BatAPI;

use BatAPI\Interfaces\Bootstrappable;

abstract class Env implements  Bootstrappable
{
    //  =========================== PARAMS ===========================
    private static array $env = [];

    //  =========================== PUBLIC METHODS ===========================

    /**
     * Boostrap the Env component.
     *
     * @return void
     */
    public static function bootstrap(): void
    {
        $envFilePath = Config::get('ROOT_PATH') . ".env";

        if (file_exists($envFilePath)) {
            $vars = file_get_contents($envFilePath);

            foreach(explode("\n", $vars) as $var) {
                if (str_starts_with($var, "#") or str_starts_with($var, '//')) {
                    continue;
                }

                $varKeyValue = explode("=", $var);
                if (!($varKeyValue[0] ?? false) or !($varKeyValue[1] ?? false)) {
                    // TODO: Warn the user about an invalid .env key.
                    continue;
                }

                $key = trim($varKeyValue[0]);
                $value = trim($varKeyValue[1], "'\" \t\r\n\v\0");

                self::$env[$key] = $value;
            }
        }
    }

    /**
     * Get a value from the .env file.
     *
     * @param string $key
     * @param mixed|null $fallback
     * @return mixed
     */
    public static function get(string $key, mixed $fallback = null): mixed
    {
        return self::$env[$key] ?? $fallback;
    }

    //  =========================== INTERNAL METHODS ===========================
}