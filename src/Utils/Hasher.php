<?php

namespace BatAPI\Utils;

abstract class Hasher
{
    public static function unique(string $prefix = ''): string
    {
        return $prefix . self::md5(uniqid(more_entropy: true) . time() . uniqid()) . time();
    }

    public static function bcrypt(string $input): string
    {
        return password_hash($input, PASSWORD_BCRYPT);
    }

    public static function md5(string $input): string
    {
        return md5($input);
    }
}