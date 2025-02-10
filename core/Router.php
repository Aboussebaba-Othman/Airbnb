<?php
namespace Core;

class Router {
    private $routes = [];

    public function add($route, $controller, $action) {
        $this->routes[$route] = [
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function dispatch($url) {
        $url = $this->removeQueryString($url);
        
        if (array_key_exists($url, $this->routes)) {
            $controllerPath = str_replace('/', '\\', $this->routes[$url]['controller']);
            $controller = "App\\Controllers\\" . $controllerPath;
            $action = $this->routes[$url]['action'];
    
            if (class_exists($controller)) {
                $controllerInstance = new $controller();
                if (method_exists($controllerInstance, $action)) {
                    return $controllerInstance->$action();
                }
            }
            throw new \Exception("Controller or action not found: $controller@$action");
        }
        throw new \Exception("No route found for URL: " . $url);
    }

    private function removeQueryString($url) {
        if ($url != '') {
            $parts = explode('?', $url);
            return $parts[0];
        }
        return $url;
    }
}