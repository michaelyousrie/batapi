<?php

namespace BatAPI;

abstract class Logger
{
    //  =========================== PARAMS ===========================

    //  =========================== PUBLIC METHODS ===========================

    /**
     * Logs an array of data to a file.
     *
     * @param string $filename
     * @param array $data
     * @param string $level
     * @return void
     */
    public static function file(string $filename, array $data, string $level = 'debug'): void
    {
        $filename = App::config('LOGS_PATH') . $filename . '.log';
        $level = strtolower($level);

        if (!file_exists($filename)) {
            touch($filename);
        }

        file_put_contents($filename, self::format($data, $level), FILE_APPEND);
    }

    //  =========================== INTERNAL METHODS ===========================

    private static function format(array $data, string $level): string
    {
        $encodedData = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $time = date('Y-m-d H:i:s');
return <<<TEXT
[{$time}] {$level}.INFO: {$encodedData}\n
TEXT;
    }
}