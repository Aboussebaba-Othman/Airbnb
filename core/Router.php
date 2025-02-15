<?php
namespace Core;

class Router {
    private static array $routes = [];

    public static function add(string $method, string $route, string $controller, string $action) {
        $pattern = preg_replace('/\{(\w+)\}/', '(?P<$1>\d+)', $route);
        $pattern = str_replace('/', '\/', $pattern);
        $pattern = '/^' . $pattern . '$/';
        
        self::$routes[$method][$pattern] = [
            'controller' => "App\\Controllers\\" . $controller,
            'action' => $action
        ];
    }

    public static function dispatch() {
        $url = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $method = $_SERVER['REQUEST_METHOD'];

        foreach (self::$routes[$method] ?? [] as $pattern => $target) {
            if (preg_match($pattern, $url, $matches)) {
                $controller = $target['controller'];
                $action = $target['action'];

                if (class_exists($controller)) {
                    $controllerInstance = new $controller();
                    
                    $params = array_filter($matches, function($key) {
                        return !is_numeric($key);
                    }, ARRAY_FILTER_USE_KEY);

                    if (method_exists($controllerInstance, $action)) {
                        return $controllerInstance->$action(...$params);
                    }
                }
            }
        }

        http_response_code(404);
        require_once dirname(__DIR__) . '/app/views/errors/404.php';
    }
}