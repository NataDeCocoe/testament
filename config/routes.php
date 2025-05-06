<?php


$routes = [
    'GET:/' => 'HomeController@index',
    'GET:/dashboard' => 'AdminController@showDashboard',
    'GET:/orders' => 'AdminController@showOrders',
    'GET:/about' => 'HomeController@showAboutUs',
    'GET:/contact' => 'HomeController@showContactUs',
    'GET:/login' => 'AuthController@showLoginForm',
    'POST:/login' => 'AuthController@login',
    'GET:/register' => 'AuthController@showRegisterForm',
    'POST:/register' => 'AuthController@register',
    'GET:/home' => 'HomeController@showHomePage',
    'GET:/categories' => 'HomeController@showCategory',
    'GET:/saved' => 'HomeController@showSaved',
    'GET:/notification' => 'HomeController@showNotification',
    'GET:/profile' => 'HomeController@showProfile',
    'GET:/logout' => 'AuthController@logout',
];
?>