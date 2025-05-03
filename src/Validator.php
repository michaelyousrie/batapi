<?php

namespace BatAPI;

abstract class Validator
{
    private static array $rules = [
        'mixed'     => '.*',
        'any'       => '.*', // Alias for mixed.
        'int'       => '\d+',
        'string'    => '(?=.*[a-zA-Z])[a-zA-Z0-9\-_\.@]+',
        'bool'      => '(true|false)',
        'hex'       => '([0-9a-fA-F]{3}|[0-9a-fA-F]{6})',
        'slug'      => '[a-zA-Z0-9\-]+',
        'ip'        => '(\d{1,3}\.){3}\d{1,3}|[0-9a-fA-F:]+',
        'ipv4'      => '(\d{1,3}\.){3}\d{1,3}',
        'ipv6'      => '[0-9a-fA-F:]+',
        'date'      => '\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])',
        'uuid'      => '[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{12}',
    ];


    public static function regexRuleFor(string $key, mixed $fallback = null): mixed
    {
        return self::$rules[$key] ?? $fallback;
    }

    public static function regexRules(): array
    {
        return self::$rules;
    }

    public static function validate(string $data, string $rule): bool
    {
        $rule = strtolower($rule);

        if (!array_key_exists($rule, self::$rules)) {
            return false;
        }

        return (bool) preg_match('/^(' . self::$rules[$rule] . ')$/', $data);
    }

    public static function isInt(string|int $data): bool
    {
        if (is_int($data)) {
            return true;
        }

        return self::validate($data, 'int');
    }

    public static function isBool(string|bool $data): bool
    {
        if (is_bool($data)) {
            return true;
        }

        return self::validate(strtolower($data), 'bool');
    }

    public static function isIp(string $data): bool
    {
        return self::validate($data, 'ip');
    }

    public static function isIpv4(string $data): bool
    {
        return self::validate($data, 'ipv4');
    }

    public static function isIpv6(string $data): bool
    {
        return self::validate($data, 'ipv6');
    }

    public static function isHex(string $data): bool
    {
        return self::validate($data, 'hex');
    }

    public static function isSlug(string $data): bool
    {
        return self::validate($data, 'slug');
    }

    public static function isDate(string $data): bool
    {
        return self::validate($data, 'date');
    }

    public static function isUuid(string $data): bool
    {
        return self::validate($data, 'uuid');
    }
}