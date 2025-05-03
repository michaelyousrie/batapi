<?php
namespace BatAPI;

use BatAPI\Interfaces\Bootstrappable;
use BatAPI\Routing\Router;

abstract class App implements Bootstrappable
{
    public static function bootstrap(): void
    {
        session_start();

        Config::set('ROOT_PATH', dirname(__DIR__)) . DIRECTORY_SEPARATOR;
        Config::set('APP_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR);
        Config::set('LOGS_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Logs' . DIRECTORY_SEPARATOR);
        Config::set('CONTROLLERS_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'Controllers'. DIRECTORY_SEPARATOR);

        Request::bootstrap();
        Env::bootstrap();
    }

    public static function start(): string
    {
        foreach(Router::routesFor(Request::method()) as $route) {
            if ($route->uriMatches(Request::uri())) {
                return $route->call();
            }
        }

        return Response::notFound([
            'message' => 'URL Not Found!'
        ]);
    }
}