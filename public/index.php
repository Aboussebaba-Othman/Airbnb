<?php
session_start();
require_once '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();
require_once '../config/routes.php';
try {
    ob_start();
    Core\Router::dispatch();
    ob_end_flush();
} catch (\Exception $e) {
    ob_clean();
    error_log($e->getMessage());
    http_response_code(404);
    require_once '../app/views/errors/404.php';
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
    <a href="/register">Register</a>
    </form>

</body>
</html>