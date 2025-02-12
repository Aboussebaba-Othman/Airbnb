<?php
namespace Core ;
class Router {
    private static $routes = [];

    public static function add($route, $controller, $method) {
        self::$routes[$route] = ['controller' => $controller, 'method' => $method];
    }

    public static function dispatch($url) {
        foreach (self::$routes as $route => $target) {
            $pattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([0-9]+)', $route);
            if (preg_match("#^$pattern$#", $url, $matches)) {
                array_shift($matches);
                $controller = "App\\controllers\\" . $target['controller'];
                $method = $target['method'];
                (new $controller())->$method(...$matches);
                return;
            }
        }
        echo "404 - Page not found";
    }

}
    
?>
