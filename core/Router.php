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
        $url = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $method = $_SERVER['REQUEST_METHOD'];
    
        error_log("URL demandée: " . $url);
        error_log("Méthode: " . $method);
    
        foreach (self::$routes[$method] as $route => $routeDetails) {
            $routePattern = preg_replace('/\{([^}]+)\}/', '(?P<\1>[^/]+)', $route);
            $routePattern = "@^" . $routePattern . "$@";
    
            if (preg_match($routePattern, $url, $matches)) {
                $controller = $routeDetails['controller'];
                $action = $routeDetails['method'];
    
                error_log("Contrôleur: " . $controller);
                error_log("Action: " . $action);
    
                if (class_exists($controller)) {
                    $controllerInstance = new $controller();
    
                    $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
    
                    if (method_exists($controllerInstance, $action)) {
                        return $controllerInstance->$action(...array_values($params));
                    }
                }
            }
        }
    
        http_response_code(404);
        include dirname(__DIR__) . '/app/views/errors/404.php';
        exit;
    }
}