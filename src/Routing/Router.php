<?php

namespace BatAPI\Routing;

use Closure;

abstract class Router
{
    private static array $routes = [
        'GET'       => [],
        'POST'      => [],
        'PUT'       => [],
        'DELETE'    => []
    ];


    public static function get(string $uri, array | Closure $callable): Route
    {
        return self::addRoute('GET', $uri, $callable);
    }

    public static function post(string $uri, array | Closure $callable): Route
    {
        return self::addRoute('POST', $uri, $callable);
    }

    public static function put(string $uri, array | Closure $callable): Route
    {
        return self::addRoute('PUT', $uri, $callable);
    }

    public static function patch(string $uri, array | Closure $callable): Route
    {
        return self::addRoute('PATCH', $uri, $callable);
    }

    public static function delete(string $uri, array | Closure $callable): Route
    {
        return self::addRoute('DELETE', $uri, $callable);
    }

    public static function all(): array
    {
        return self::$routes;
    }

    public static function routesFor(string $method): array
    {
        return self::$routes[strtoupper($method)];
    }

    
    private static function addRoute(string $method, string $uri, mixed $callable): Route
    {
        $uri = "/" . trim($uri, '/');

        $route = new Route($uri, $callable);
        self::$routes[$method][] = $route;

        return $route;
    }
}