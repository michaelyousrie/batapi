<?php

namespace BatAPI;

class Response
{
    //  =========================== PARAMS ===========================

    //  =========================== PUBLIC METHODS ===========================

    /**
     * Return a RAW JSON response
     *
     * @param array $data
     * @param integer $statusCode
     * @param array $headers
     * @return string
     */
    public static function raw(array $data, int $statusCode, array $headers = []): string
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');

        foreach($headers as $header => $value) {
            header("{$header}: {$value}");
        }

        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    /**
     * Return a successful, 200 response.
     *
     * @param array $data
     * @return string
     */
    public static function success(array $data = []): string
    {
        return self::raw($data, 200);
    }

    /**
     * Return a 404 not found error
     *
     * @return string
     */
    public static function notFound(array $data = []): string
    {
        return self::raw($data, 404);
    }

    /**
     * Return a special 500 debugging response. Useful for development.
     *
     * @param array $data
     * @return string
     */
    public static function debug(array $data): string
    {
        return self::raw($data, 500, ['X_IS_DEBUGGING' => true]);
    }

    //  =========================== INTERNAL METHODS ===========================
}
