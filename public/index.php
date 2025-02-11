<?php
require '../vendor/autoload.php';
require '../config/routes.php';

// Remove any existing output buffers
while (ob_get_level()) {
    ob_end_clean();
}

// Start a new output buffer
ob_start();

Core\Router::dispatch();

ob_end_flush();
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