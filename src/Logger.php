<?php

namespace BatAPI;

use BatAPI\DataSources\File;
use BatAPI\Utils\DateTime;
use BatAPI\Utils\JSON;

abstract class Logger
{
    public static function file(string $filename, array $data, string $level = 'debug'): void
    {
        $file = new File(File::constructPath([Config::get('LOGS_PATH'), "{$filename}.log"]));
        $level = strtolower($level);


        $file->write(self::format($data, $level));
    }

    public static function dailyFile(string $filename, array $data, string $level = 'debug'): void
    {
        $filename = $filename . "_" . DateTime::date();

        self::file($filename, $data, $level);
    }


    private static function format(array $data, string $level): string
    {
        $encodedData = JSON::encode($data);
        $time = DateTime::now();
return <<<TEXT
[{$time}] {$level}.INFO: {$encodedData}\n
TEXT;
    }
}