<?php


$routes = [
    'GET:/' => 'HomeController@index',
    'GET:/about' => 'HomeController@showAboutUs',
    'GET:/contact' => 'HomeController@showContactUs',
    'GET:/login' => 'AuthController@showLoginForm',
    'POST:/login' => 'AuthController@login',
    'GET:/register' => 'AuthController@showRegisterForm',
    'POST:/register' => 'AuthController@register',
];
?>