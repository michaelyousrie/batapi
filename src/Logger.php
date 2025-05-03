<?php

namespace BatAPI;

use BatAPI\Utils\JSON;

abstract class Logger
{
    //  =========================== PARAMS ===========================

    //  =========================== PUBLIC METHODS ===========================

    public static function file(string $filename, array $data, string $level = 'debug'): void
    {
        $filename = Config::get('LOGS_PATH') . $filename . '.log';
        $level = strtolower($level);

        if (!file_exists($filename)) {
            touch($filename);
        }

        file_put_contents($filename, self::format($data, $level), FILE_APPEND);
    }

    public static function dailyFile(string $filename, array $data, string $level = 'debug'): void
    {
        $filename = $filename . "_" . date('Y-m-d');

        self::file($filename, $data, $level);
    }

    //  =========================== INTERNAL METHODS ===========================

    private static function format(array $data, string $level): string
    {
        $encodedData = JSON::encode($data);
        $time = date('Y-m-d H:i:s');
return <<<TEXT
[{$time}] {$level}.INFO: {$encodedData}\n
TEXT;
    }
}