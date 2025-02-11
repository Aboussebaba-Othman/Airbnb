<?php
namespace Core ;
class Router {
    private static $routes = [];

    public static function add($route, $controller, $method) {
        self::$routes[$route] = ['controller' => $controller, 'method' => $method];
    }

    public static function dispatch($url) {
        if (isset(self::$routes[$url])) {
            $controller = "App\\controllers\\" . self::$routes[$url]['controller'];
            $method = self::$routes[$url]['method'];
            (new $controller())->$method();
        } else {
            echo "404 - Page not found";
        }
    }
}
?>
