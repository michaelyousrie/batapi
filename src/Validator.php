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
        'hex'       => '[0-9a-fA-F]+',
        'slug'      => '[a-zA-Z0-9\-]+',
        'ip'        => '\d{1,3}\.){3}\d{1,3}|[0-9a-fA-F:]+',
        'date'      => '\d{4}-\d{2}-\d{2}',
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

    //  =========================== INTERNAL METHODS ===========================
}