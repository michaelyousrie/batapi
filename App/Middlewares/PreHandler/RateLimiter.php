<?php

namespace App\Middlewares\PreHandler;

use BatAPI\Config;
use BatAPI\DataSources\File;
use BatAPI\Interfaces\Middleware\PreHandlerMiddleware;
use BatAPI\Request;
use BatAPI\Response;
use BatAPI\Utils\JSON;

class RateLimiter extends PreHandlerMiddleware
{
    public const PER_MINUTE = 60;
    public const PER_HOUR = 3600;
    public const PER_DAY = 86400;
    public const PER_MONTH = 2592000;
    public const PER_YEAR = 31536000;


    public function __construct(private int $rateLimit, private string $per = RateLimiter::PER_MINUTE, private string $limiterName = 'default' )
    {
    }

    public function handle(): void
    {
        $ipAddress = Request::ip();
        if ($this->isRateLimited($ipAddress)) {
            Request::kill(Response::rateLimited());
            exit;
        }

        $this->logRequest($ipAddress);
    }


    private function isRateLimited(string $ipAddress): bool
    {
        $logFile = new File(File::constructPath([Config::get('LOGS_PATH'), 'RateLimiters', "{$this->limiterName}.json"]));
        $logData = JSON::decode($logFile->read());

        $currentTimestamp = time();

        // Filter only logs within the current period
        $logData[$ipAddress] = $logData[$ipAddress] ?? [];
        $logData[$ipAddress] = array_filter($logData[$ipAddress], function ($timestamp) use ($currentTimestamp) {
            return $currentTimestamp - $timestamp <= $this->per;
        });

        // Check if the request limit is exceeded
        return count($logData[$ipAddress]) >= $this->rateLimit;
    }

    private function logRequest(string $ipAddress): void
    {
        $logFile = new File(File::constructPath([Config::get('LOGS_PATH'), 'RateLimiters', "{$this->limiterName}.json"]));
        $logData = JSON::decode($logFile->read());

        // Add the current request to logs
        $logData[$ipAddress][] = time();

        // Write updated logs back to file
        $logFile->write(JSON::encode($logData), false);
    }
}