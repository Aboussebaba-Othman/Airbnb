<?php
use Core\Router;

Router::add('/', 'HomeController', 'index');
Router::add('/login', 'AuthController', 'login');
Router::add('/annonces', 'AnnonceController', 'index');
Router::add('/reservation/{id}', 'ReservationController', 'show');
Router::add('/reservation/book', 'ReservationController', 'book');







?>