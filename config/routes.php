<?php


$routes = [

    // Home
    'GET:/' => 'HomeController@index',
    'GET:/about' => 'HomeController@showAboutUs',
    'GET:/contact' => 'HomeController@showContactUs',

    //Admin
    'GET:/dashboard' => 'AdminController@showDashboard',
    'GET:/orders' => 'AdminController@showOrders',
    'GET:/inventory/view' => 'AdminController@showInventory',
    'GET:/inventory' => 'ProductController@getProducts',
    'POST:/admin/inventory' => 'ProductController@addProduct',
    'GET:/admin/inventory/show' => 'ProductController@show',
    'POST:/admin/inventory/update' => 'ProductController@updateProduct',
    'POST:/admin/inventory/delete' => 'ProductController@deleteProduct',
    'GET:/admin/inventory/count' => 'ProductController@countProducts',
    'GET:/admin/users/count' => 'UserController@countUsers',


    // Auth
    'GET:/login' => 'AuthController@showLoginForm',
    'GET:/register' => 'AuthController@showRegisterForm',
    'POST:/login' => 'AuthController@login',
    'POST:/register' => 'AuthController@register',

    // User
    'GET:/home' => 'HomeController@showHomePage',
    'GET:/categories' => 'HomeController@showCategory',
    'GET:/saved' => 'HomeController@showSaved',
    'GET:/notification' => 'HomeController@showNotification',
    'GET:/profile' => 'HomeController@showProfile',
    'GET:/profile' => 'ProfileController@showProfile',

    // Pages
    'GET:/home/products' => 'ProductController@getAllForNewRealease',
    'GET:/home/all-products' => 'ProductController@getAllProducts',
    'GET:/categories/products' => 'ProductController@getAllProductsForCategories',
    'GET:/home/product/{id}' => 'ProductController@getProduct',


    'GET:/logout' => 'AuthController@logout',
];
?>