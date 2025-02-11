<?php
namespace Core;

class Router {
    private static array $routes = [];

    public static function add(string $method, string $route, string $controller, string $action) {
        $route = trim($route, '/');
        self::$routes[$method][$route] = [
            'controller' => "App\\Controllers\\" . $controller,
            'method' => $action
        ];
    }

    public static function dispatch() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $url = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $method = $_SERVER['REQUEST_METHOD'];

        if (isset(self::$routes[$method][$url])) {
            $controller = self::$routes[$method][$url]['controller'];
            $action = self::$routes[$method][$url]['method'];

            if (class_exists($controller)) {
                $controllerInstance = new $controller();
                if (method_exists($controllerInstance, $action)) {
                    return $controllerInstance->$action();
                }
            }
        }

        http_response_code(404);
        $errorPath = dirname(__DIR__) . '/app/views/errors/404.php';
        
        if (file_exists($errorPath)) {
            include $errorPath;
        } else {
            echo "404 - Page Not Found";
        }
    }
}