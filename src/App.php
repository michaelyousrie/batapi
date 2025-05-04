<?php
namespace BatAPI;

use BatAPI\DataSources\File;
use BatAPI\Interfaces\Bootstrappable;
use BatAPI\Routing\Router;

abstract class App implements Bootstrappable
{
    public static function bootstrap(): void
    {
        session_start();

        Config::set('ROOT_PATH', dirname(__DIR__));
        Config::set('APP_PATH', File::constructPath([Config::get('ROOT_PATH'), 'App']));
        Config::set('LOGS_PATH', File::constructPath([Config::get('ROOT_PATH'), 'Logs']));
        Config::set('CONTROLLERS_PATH', File::constructPath([Config::get('APP_PATH'), 'Controllers']));

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