<?php

namespace BatAPI\Routing;

use BatAPI\Controller;
use BatAPI\Request;
use BatAPI\Validator;
use Closure;
use function BatAPI\Utils\dd;

class Route
{
    //  =========================== PARAMS ===========================
    private static array $acceptedParamTypes = [];

    private array $middlewares = [];

    //  =========================== PUBLIC METHODS ===========================

    public function __construct(private string $uri, private mixed $callable)
    {
        foreach(array_keys(Validator::regexRules()) as $dataType) {
            self::$acceptedParamTypes[] = $dataType;
        }
    }

    public function uri(?string $newUri = null): Route | string
    {
        if (is_null($newUri)) {
            return $this->uri;
        }

        $this->uri = $newUri;

        return $this;
    }

    public function middlewares(array $middlewares = []): array|Route
    {
        if (empty($middlewares)) {
            return $this->middlewares;
        }

        $this->middlewares = $middlewares;
        return $this;
    }

    public function uriMatches(string $uri): bool
    {
        $acceptedParams = implode("|", self::$acceptedParamTypes);
        $pattern = preg_replace_callback(
            "#\{(?<type>{$acceptedParams}):(?<name>\w+)\}#",
            function ($matches) {
                $name = $matches['name'];
                foreach(Validator::regexRules() as $dataType => $pattern) {
                    if (strtolower($matches['type']) === strtolower($dataType)) {
                        return "(?<{$name}>{$pattern})";
                    }
                }

                return "";
            },
            $this->uri
        );

        $regex = "#^" . $pattern . "$#i";

        if (preg_match($regex, $uri, $matches)) {
            $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

            foreach($params as $key => $param) {
                Request::setUrlParam($key, $param);
            }
        }

        return (bool) preg_match($regex, $uri);
    }

    public function call(): string
    {
        foreach($this->middlewares() as $middleware) {
            $middleware = new $middleware();
            $middleware->handle();
        }

        if ($this->callable instanceof Closure) {
            return call_user_func($this->callable);
        }

        if (is_array($this->callable)) {
            return Controller::determine($this->callable);
        }

        dd('Unknown Callable type for this route.');
        return false;
    }

    //  =========================== INTERNAL METHODS ===========================
}