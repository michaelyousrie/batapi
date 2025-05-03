<?php

namespace BatAPI;

use BatAPI\Utils\JSON;

abstract class Response
{
    public static function raw(array $data, int $statusCode, array $headers = []): string
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');

        foreach($headers as $header => $value) {
            header("{$header}: {$value}");
        }

        return JSON::encode($data);
    }

    public static function success(array $data = []): string
    {
        return self::raw($data, 200);
    }

    public static function notFound(array $data = []): string
    {
        return self::raw($data, 404);
    }

    public static function debug(array $data): string
    {
        return self::raw($data, 500, ['BatAPI_IS_DEBUGGING' => true]);
    }
}
