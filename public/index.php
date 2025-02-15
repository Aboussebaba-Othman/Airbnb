<?php

require '../vendor/autoload.php';
require '../config/routes.php';
use Core\Router;
use App\models\AnnonceModel;

$url = $_SERVER['REQUEST_URI'];
$url = strtok($url, '?'); 

Router::dispatch($url);
