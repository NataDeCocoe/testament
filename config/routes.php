<?php


$routes = [

    // Home
    'GET:/' => 'HomeController@index',
    'GET:/about' => 'HomeController@showAboutUs',
    'GET:/contact' => 'HomeController@showContactUs',

    //Admin
    'GET:/dashboard' => 'AdminController@showDashboard',
    'GET:/pending-orders' => 'Ordercontroller@getOrders',
    'GET:/pending-orders/view' => 'AdminController@showPendingOrders',
    'GET:/pending-orders/details/{id}' => 'OrderController@orderDetails',
    'GET:/orders' => 'AdminController@showOrders',
    'GET:/inventory/view' => 'AdminController@showInventory',
    'GET:/inventory' => 'ProductController@getProducts',
    'POST:/admin/inventory' => 'ProductController@addProduct',
    'GET:/admin/inventory/show' => 'ProductController@show',
    'POST:/admin/inventory/update' => 'ProductController@updateProduct',
    'POST:/admin/inventory/delete' => 'ProductController@deleteProduct',
    'GET:/admin/inventory/count' => 'ProductController@countProducts',
    'GET:/admin/users/count' => 'UserController@countUsers',
    'GET:/admin/orders/count' => 'OrderController@countOrders',



    // Auth
    'GET:/login' => 'AuthController@showLoginForm',
    'GET:/register' => 'AuthController@showRegisterForm',
    'POST:/login' => 'AuthController@login',
    'POST:/register' => 'AuthController@register',

    // User
    'GET:/home' => 'HomeController@showHomePage',
    'GET:/categories' => 'HomeController@showCategory',
    'GET:/saved' => 'HomeController@showSaved',
    'GET:/my-orders' => 'HomeController@showMyOrders',
    'GET:/notification' => 'HomeController@showNotification',
    'GET:/profile' => 'HomeController@showProfile',
    'GET:/profile' => 'ProfileController@showProfile',
    'GET:/cart' => 'HomeController@showCart',
    'GET:/checkout' => 'HomeController@showCheckout',

    // Pages
    'GET:/home/products' => 'ProductController@getAllForNewRealease',
    'GET:/home/all-products' => 'ProductController@getAllProducts',
    'GET:/categories/products' => 'ProductController@getAllProductsForCategories',
    'GET:/home/product/{id}' => 'ProductController@getProduct',

    //Cart
    'POST:/cart/add' => 'CartController@add',
    'GET:/cart/count' => 'CartController@count',
    'GET:/cart/view' => 'CartController@view',
    'POST:/cart/remove/{id}' => 'CartController@remove',
    'GET:/cart/items' => 'CartController@getItems',
    'POST:/cart/update/{id}' => 'CartController@updateCartQuantity',
    'POST:/cart/clear' => 'CartController@clearAfterCheckout',

    //CHECKOUT
    'GET:/checkout/getItems' => 'CartController@getItems',
    'GET:/delivery-options' => 'DeliveryController@getOptions',
    'GET:/payment-options' => 'PaymentController@getOptions',
    'POST:/orders/place' => 'OrderController@place',
    'GET:/success' => 'HomeController@showSuccess',

    'GET:/logout' => 'AuthController@logout',
];
?>