<?php
session_start();
require_once '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$router = new Core\Router();

$routes = require_once '../config/routes.php';

foreach ($routes as $route => $params) {
    list($method, $path) = explode('|', $route);
    list($controller, $action) = explode('@', $params);
    $router->add($path, $controller, $action);
}

$url = trim($_SERVER['REQUEST_URI'], '/');

try {
    $router->dispatch($url);
} catch (\Exception $e) {
    echo "Erreur: " . $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
 
    <form action="/login" method="GET">
    <a href="/login">Login</a>
    </form>

</body>
</html>