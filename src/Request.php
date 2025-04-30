<?php
namespace BatAPI;

use BatAPI\Interfaces\Bootstrappable;

abstract class Request implements Bootstrappable
{
    //  =========================== PARAMS ===========================

    private static array $data = [];
    private static array $query = [];
    private static array $headers = [];

    private static string $method = 'GET';

    //  =========================== PUBLIC METHODS ===========================

    /**
     * Bootstraps Request Component
     *
     * @return void
     */
    public static function bootstrap(): void
    {
        self::bootstrapData();
        self::bootstrapQuery();
        self::bootstrapHeaders();

        self::$method = strtoupper($_SERVER['REQUEST_METHOD'] ?? '') ?? 'GET';
    }

    /**
     * Return the request method in uppercase. GET, POST, UPDATE, PATCH, DELETE
     *
     * @return string
     */
    public static function method(): string
    {
        return self::$method;
    }

    /**
     * Tries to fetch a param either from the query or the post data by key.
     *
     * @param string $key
     * @param mixed $fallback
     * @return mixed
     */
    public static function get(string $key, mixed $fallback = null): mixed
    {
        return self::$data[$key] ?? self::$query[$key] ?? $fallback;
    }

    /**
     * Return a param by only checking the query params. Used in GET requests.
     *
     * @param string $key
     * @param mixed $fallback
     * @return mixed
     */
    public static function query(?string $key = null, mixed $fallback = null): mixed
    {
        if (is_null($key)) {
            return self::$query;
        }

        return self::$query[$key] ?? $fallback;
    }

    /**
     * Return a param by only checking the post data. Used in POST requests.
     *
     * @param string $key
     * @param mixed $fallback
     * @return mixed
     */
    public static function data(?string $key = null, mixed $fallback = null): mixed
    {
        if (is_null($key)) {
            return self::$data;
        }

        return self::$data[$key] ?? $fallback;
    }

    /**
     * Return a header from the request headers.
     *
     * @param string $key
     * @param mixed $fallback
     * @return mixed
     */
    public static function header(?string $key = null, mixed $fallback = null): mixed
    {
        if (is_null($key)) {
            return self::headers();
        }

        return self::$headers[$key] ?? $fallback;
    }

    /**
     * Return all headers.
     *
     * @return array
     */
    public static function headers(): array
    {
        return self::$headers;
    }

    public static function uri(): string
    {
        return rtrim(self::$headers['PHP_SELF'], '/');
    }

    //  =========================== INTERNAL METHODS ===========================

    /**
     * Bootstrap the data array
     *
     * @return void
     */
    private static function bootstrapData(): void
    {
        foreach($_POST as $key => $value) {
            self::$data[$key] = $value;
        }
    }

    /**
     * Bootstrap the query params array
     *
     * @return void
     */
    private static function bootstrapQuery(): void
    {
        foreach($_GET as $key => $value) {
            self::$query[$key] = $value;
        }
    }

    /**
     * Bootstrap the headers array
     *
     * @return void
     */
    private static function bootstrapHeaders(): void
    {
        foreach($_SERVER as $key => $value) {
            self::$headers[$key] = $value;
        }
    }
}
