<?php

namespace BatAPI\Http;

use BatAPI\Utils\JSON;

class HttpResponse
{
    public function __construct(private string $body, private int $statusCode, private ?string $error = null)
    {
        if ($this->hasErrors()) {
            $this->body = $this->error;
        }
    }

    public function json(): array
    {
        return JSON::decode($this->body);
    }

    public function body(): string
    {
        return $this->body;
    }

    public function statusCode(): int
    {
        return $this->statusCode;
    }

    public function hasErrors(): bool
    {
        return $this->error !== '' or $this->statusCode >= 400;
    }

    public function error(): ?string
    {
        return $this->error;
    }

    public function isNotFound(): bool
    {
        return $this->statusCode === 404;
    }

    public function isServerError(): bool
    {
        return $this->statusCode >= 500;
    }
}