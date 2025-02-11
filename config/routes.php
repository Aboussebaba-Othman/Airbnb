<?php
use Core\Router;

Router::add('GET', '/', 'HomeController', 'index');
Router::add('GET', 'login', 'AuthController', 'login');
Router::add('POST', 'login', 'AuthController', 'login');
Router::add('GET', 'logout', 'AuthController', 'logout');
Router::add('GET', 'admin/dashboard', 'DashboardController', 'index');
Router::add('GET', 'owner/dashboard', 'DashboardController', 'ownerDashboard');
Router::add('GET', 'traveler/dashboard', 'DashboardController', 'travelerDashboard');
