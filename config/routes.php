<?php
return [
    'GET|' => 'HomeController@index',
    'GET|login' => 'AuthController@login',
    'POST|login' => 'AuthController@login',
    'GET|register' => 'AuthController@register',
    'POST|register' => 'AuthController@register',
    'GET|logout' => 'AuthController@logout',
    'GET|admin/dashboard' => 'DashboardController@index'
    
];