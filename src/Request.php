<?php
namespace BatAPI;

use BatAPI\Interfaces\Bootstrappable;

abstract class Request implements Bootstrappable
{
    private static array $data = [];
    private static array $query = [];
    private static array $headers = [];
    private static array $urlParams = [];
    private static array $custom = [];
    private static string $method = 'GET';


    public static function bootstrap(): void
    {
        self::bootstrapData();
        self::bootstrapQuery();
        self::bootstrapHeaders();

        self::$method = strtoupper($_SERVER['REQUEST_METHOD'] ?? '') ?: 'GET';
    }

    public static function method(): string
    {
        return self::$method;
    }

    public static function get(string $key, mixed $fallback = null): mixed
    {
        return self::$data[$key] ?? self::$query[$key] ?? $fallback;
    }

    public static function query(?string $key = null, mixed $fallback = null): mixed
    {
        if (is_null($key)) {
            return self::$query;
        }

        return self::$query[$key] ?? $fallback;
    }

    public static function data(?string $key = null, mixed $fallback = null): mixed
    {
        if (is_null($key)) {
            return self::$data;
        }

        return self::$data[$key] ?? $fallback;
    }

    public static function header(?string $key = null, mixed $fallback = null): mixed
    {
        if (is_null($key)) {
            return self::headers();
        }

        return self::$headers[$key] ?? $fallback;
    }

    public static function custom(string $key, mixed $value = null, mixed $fallback = null): mixed
    {
        if (!is_null($value)) {
            self::$custom[$key] = $value;

            return $value;
        }

        return self::$custom[$key] ?? $fallback;
    }

    public static function setUrlParam(string $key, mixed $value): mixed
    {
        return self::$urlParams[$key] = $value;
    }

    public static function urlParam(string $key, mixed $fallback = null): mixed
    {
        return self::$urlParams[$key] ?? $fallback;
    }

    public static function headers(): array
    {
        return self::$headers;
    }

    public static function uri(): string
    {
        return "/" . trim(self::$headers['PHP_SELF'], '/');
    }

    public static function ip(): string
    {
        return self::$headers['REMOTE_ADDR'] ?? self::$headers['HTTP_X_FORWARDED_FOR'] ?? '';
    }

    public static function kill(string $response): void
    {
        echo $response;
        exit;
    }


    private static function bootstrapData(): void
    {
        foreach($_POST as $key => $value) {
            self::$data[$key] = $value;
        }
    }

    private static function bootstrapQuery(): void
    {
        foreach($_GET as $key => $value) {
            self::$query[$key] = $value;
        }
    }

    private static function bootstrapHeaders(): void
    {
        foreach($_SERVER as $key => $value) {
            self::$headers[$key] = $value;
        }
    }
}
