<?php

namespace BatAPI\DataSources;

use BatAPI\Interfaces\DataSource;

class File extends DataSource
{
    public function __construct(private mixed $source)
    {
    }

    public static function constructPath(array $paths): string
    {
        return implode(DIRECTORY_SEPARATOR, $paths);
    }

    public function read(): string
    {
        if (!$this->exists()) {
            mkdir(dirname($this->source), recursive: true);
            touch($this->source);
        }

        return file_get_contents($this->source) ?? '';
    }

    public function write(mixed $value, bool $append = true): void
    {
        file_put_contents($this->source, $value, $append ? FILE_APPEND : 0);
    }

    public function exists(): bool
    {
        return file_exists($this->source);
    }
}