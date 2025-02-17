<?php
use Core\Router;

Router::add('GET', 'annonces', 'AnnonceController', 'index');
Router::add('GET', 'reservation/{id}', 'ReservationController', 'getAnnonceReserve');
Router::add('GET', 'reserver', 'ReservationController', 'reserver');

Router::add('GET', '', 'HomeController', 'index');

Router::add('GET', 'login', 'AuthController', 'login');
Router::add('POST', 'login', 'AuthController', 'login');
Router::add('GET', 'register', 'AuthController', 'register');
Router::add('POST', 'register', 'AuthController', 'register');
Router::add('GET', 'logout', 'AuthController', 'logout');

Router::add('GET', 'admin/dashboard', 'AdminDashboardController', 'index');
Router::add('GET', 'traveler/dashboard', 'TravelerController', 'index');

Router::add('GET', 'auth/google', 'AuthController', 'googleAuth');
Router::add('GET', 'auth/google/callback', 'AuthController', 'googleCallback');
Router::add('GET', 'auth/facebook', 'AuthController', 'facebookAuth');
Router::add('GET', 'auth/facebook/callback', 'AuthController', 'facebookCallback');


Router::add('GET', 'auth/complete-registration', 'AuthController', 'completeRegistration');
Router::add('POST', 'auth/complete-registration', 'AuthController', 'completeRegistration');


Router::add('GET', 'admin/users', 'UserController', 'index');
Router::add('GET', 'admin/users/delete/{id}', 'UserController', 'delete');
Router::add('GET', 'admin/users/toggle-status/{id}', 'UserController', 'toggleStatus');

Router::add('GET', 'admin/validation', 'AdminAnnonceController', 'validation');
Router::add('GET', 'admin/toggle-validation/{id}', 'AdminAnnonceController', 'toggleValidation');

Router::add('GET', 'profile/edit', 'ProfileController', 'edit');
Router::add('POST', 'profile/edit', 'ProfileController', 'update');

Router::add('GET', 'property/index', 'PropertyController', 'index');
Router::add('GET', 'property/create', 'PropertyController', 'create');
Router::add('POST', 'property/store', 'PropertyController', 'store');
Router::add('GET', 'property/edit/{id}', 'PropertyController', 'edit');
Router::add('POST', 'property/update/{id}', 'PropertyController', 'update');
Router::add('GET', 'property/delete/{id}', 'PropertyController', 'delete');









Router::add('GET', 'property/index', 'PropertyController', 'index');
Router::add('GET', 'property/create', 'PropertyController', 'create');
Router::add('POST', 'property/store', 'PropertyController', 'store');
Router::add('GET', 'property/edit/{id}', 'PropertyController', 'edit');
Router::add('POST', 'property/update/{id}', 'PropertyController', 'update');
Router::add('GET', 'property/delete/{id}', 'PropertyController', 'delete');