<?php

namespace BatAPI;

abstract class Validator
{
    //  =========================== PARAMS ===========================
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

    //  =========================== PUBLIC METHODS ===========================

    /**
     * Return the regex rule used to validate a specific type of data.
     *
     * @param string $key
     * @param mixed|null $fallback
     * @return mixed
     */
    public static function regexRuleFor(string $key, mixed $fallback = null): mixed
    {
        return self::$rules[$key] ?? $fallback;
    }

    /**
     * Return all configured regex rules.
     *
     * @return array|string[]
     */
    public static function regexRules(): array
    {
        return self::$rules;
    }

    /**
     * Validate the given $data against a pre-defined validation rule.
     *
     * @param string $data
     * @param string $rule
     * @return bool
     */
    public static function validate(string $data, string $rule): bool
    {
        $rule = strtolower($rule);

        if (!array_key_exists($rule, self::$rules)) {
            return false;
        }

        return (bool) preg_match('/^(' . self::$rules[$rule] . ')$/', $data);
    }

    /**
     * @param string|int $data
     * @return bool
     */
    public static function isInt(string|int $data): bool
    {
        if (is_int($data)) {
            return true;
        }

        return self::validate($data, 'int');
    }

    /**
     * @param string|bool $data
     * @return bool
     */
    public static function isBool(string|bool $data): bool
    {
        if (is_bool($data)) {
            return true;
        }

        return self::validate(strtolower($data), 'bool');
    }

    /**
     * @param string $data
     * @return bool
     */
    public static function isIp(string $data): bool
    {
        return self::validate($data, 'ip');
    }

    /**
     * @param string $data
     * @return bool
     */
    public static function isIpv4(string $data): bool
    {
        return self::validate($data, 'ipv4');
    }

    /**
     * @param string $data
     * @return bool
     */
    public static function isIpv6(string $data): bool
    {
        return self::validate($data, 'ipv6');
    }

    /**
     * @param string $data
     * @return bool
     */
    public static function isHex(string $data): bool
    {
        return self::validate($data, 'hex');
    }

    /**
     * @param string $data
     * @return bool
     */
    public static function isSlug(string $data): bool
    {
        return self::validate($data, 'slug');
    }

    /**
     * @param string $data
     * @return bool
     */
    public static function isDate(string $data): bool
    {
        return self::validate($data, 'date');
    }

    /**
     * @param string $data
     * @return bool
     */
    public static function isUuid(string $data): bool
    {
        return self::validate($data, 'uuid');
    }

    //  =========================== INTERNAL METHODS ===========================
}