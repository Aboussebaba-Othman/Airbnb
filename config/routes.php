<?php
use Core\Router;

Router::add('/', 'HomeController', 'index');
Router::add('/login', 'AuthController', 'login');
Router::add('/annonces', 'AnnonceController', 'index');
Router::add('/reservation/{id}', 'ReservationController', 'getAnnonceReserve');
Router::add('/reserver', 'ReservationController', 'reserver');
Router::add('/paiement/{id}', 'PaiementController', 'showPaiement');
Router::add('/paiement/initier/{id}', 'PaiementController', 'initierPaiement');
Router::add('/paiement/success/{id}', 'PaiementController', 'success');
Router::add('/paiement/cancel/{id}', 'PaiementController', 'cancel');

?>