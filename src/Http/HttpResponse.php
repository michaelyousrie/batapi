<?php

namespace BatAPI\Http;

use BatAPI\Utils\JSON;

class HttpResponse
{
    //  =========================== PARAMS ===========================

    //  =========================== PUBLIC METHODS ===========================
    public function __construct(private string $body, private int $statusCode, private ?string $error = null)
    {
        if ($this->hasErrors()) {
            $this->body = $this->error;
        }
    }

    /**
     * Decode the JSON response and get an array.
     *
     * @return array
     */
    public function json(): array
    {
        return JSON::decode($this->body);
    }

    /**
     * Get the raw body of the response.
     *
     * @return string
     */
    public function body(): string
    {
        return $this->body;
    }

    /**
     * Get the request's status code.
     *
     * @return int
     */
    public function statusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Check if the request has any errors.
     *
     * @return bool
     */
    public function hasErrors(): bool
    {
        return $this->error !== '' or $this->statusCode >= 400;
    }

    /**
     * Get the request error.
     *
     * @return string|null
     */
    public function error(): ?string
    {
        return $this->error;
    }

    /**
     * Checks if the response code is 404.
     *
     * @return bool
     */
    public function isNotFound(): bool
    {
        return $this->statusCode === 404;
    }

    /**
     * Checks if the response code is >= 500.
     *
     * @return bool
     */
    public function isServerError(): bool
    {
        return $this->statusCode >= 500;
    }

    //  =========================== INTERNAL METHODS ===========================
}