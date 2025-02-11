<?php
use Core\Router;

Router::add('/', 'HomeController', 'index');
Router::add('/login', 'AuthController', 'login');
Router::add('/reserver', 'ReservationController', 'reserver');
Router::add('/payer', 'ReservationController', 'payer');
Router::add('/annonces', 'AnnonceController', 'index');
Router::add('/reservation', 'ReservationController', 'details');







?>