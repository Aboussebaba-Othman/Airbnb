
<?php
use Core\Router;


Router::add('GET', 'annonces', 'AnnonceController', 'index');
Router::add('GET', 'reservation/{id}', 'ReservationController', 'getAnnonceReserve');
Router::add('GET', 'reserver', 'ReservationController', 'reserver');




?>