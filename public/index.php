<?php
session_start();
require_once '../vendor/autoload.php';
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
