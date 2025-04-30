<?php

namespace BatAPI\Routing;

use Closure;
use BatAPI\Routing\Route;

class Router
{
    //  =========================== PARAMS ===========================

    private static array $routes = [
        'GET'       => [],
        'POST'      => [],
        'PUT'       => [],
        'DELETE'    => []
    ];

    //  =========================== PUBLIC METHODS ===========================

    /**
     * Adds a GET request route listener.
     *
     * @param string $uri The URI to listen for. e.g. /test
     * @param string|Closure $callable The Callable to be executed when the URI is requested.
     * @return void
     */
    public static function get(string $uri, string | Closure $callable): void
    {
        self::addRoute('GET', $uri, $callable);
    }

    /**
     * Adds a POST request route listener.
     *
     * @param string $uri The URI to listen for. e.g. /test
     * @param string|Closure $callable The Callable to be executed when the URI is requested.
     * @return void
     */
    public static function post(string $uri, string | Closure $callable): void
    {
        self::addRoute('POST', $uri, $callable);
    }

    /**
     * Adds a PUT request route listener.
     *
     * @param string $uri The URI to listen for. e.g. /test
     * @param string|Closure $callable The Callable to be executed when the URI is requested.
     * @return void
     */
    public static function put(string $uri, string | Closure $callable): void
    {
        self::addRoute('PUT', $uri, $callable);
    }

    /**
     * Adds a PATCH request route listener.
     *
     * @param string $uri The URI to listen for. e.g. /test
     * @param string|Closure $callable The Callable to be executed when the URI is requested.
     * @return void
     */
    public static function patch(string $uri, string | Closure $callable): void
    {
        self::addRoute('PATCH', $uri, $callable);
    }

    /**
     * Adds a DELETE request route listener.
     *
     * @param string $uri The URI to listen for. e.g. /test
     * @param string|Closure $callable The Callable to be executed when the URI is requested.
     * @return void
     */
    public static function delete(string $uri, string | Closure $callable): void
    {
        self::addRoute('DELETE', $uri, $callable);
    }

    /**
     * Fetches all of the currently registered routes. Useful for debugging.
     *
     * @return array
     */
    public static function all(): array
    {
        return self::$routes;
    }

    /**
     * Return an array of all registered routes for a specific HTTP Method (GET, POST, PATCH, UPDATE, DELETE)
     *
     * @param string $method
     * @return array
     */
    public static function routesFor(string $method): array
    {
        return self::$routes[strtoupper($method)];
    }

    //  =========================== INTERNAL METHODS ===========================

    /**
     * Register a route
     *
     * @param string $method
     * @param string $uri
     * @param mixed $callable
     * @return void
     */
    private static function addRoute(string $method, string $uri, mixed $callable): void
    {
        $uri = rtrim($uri, '/');

        $callableType = 'string';

        if ($callable instanceof Closure) {
            $callableType = 'closure';
        }

        self::$routes[$method][] = new Route($uri, $callable, $callableType);
    }
}