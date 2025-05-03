<?php

namespace BatAPI\Utils;

abstract class Password
{
    public static function hash(string $password): string
    {
        return Hasher::bcrypt($password);
    }

    // @Alias
    public static function new(string $password): string
    {
        return self::hash($password);
    }

    public static function verify(string $password, string $hash): bool
    {
        return Hasher::bcryptMatches($password, $hash);
    }
}