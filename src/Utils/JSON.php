<?php

namespace BatAPI\Utils;

abstract class JSON
{
    public static function encode(array $data): string
    {
        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    public static function decode(string $json): array
    {
        return json_decode($json, associative: true) ?? [];
    }
}