<?php
use Core\Router;

Router::add('GET', 'login', 'AuthController', 'login');
Router::add('POST', 'login', 'AuthController', 'login');
Router::add('GET', 'register', 'AuthController', 'register');
Router::add('POST', 'register', 'AuthController', 'register');
Router::add('GET', 'logout', 'AuthController', 'logout');

Router::add('GET', 'admin/dashboard', 'AdminDashboardController', 'index');
Router::add('GET', 'owner/dashboard', 'OwnerDashboardController', 'index');

Router::add('GET', '', 'HomeController', 'index');
