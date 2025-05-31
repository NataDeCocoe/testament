<?php


$routes = [

    // Home
    'GET:/' => 'HomeController@index',
    'GET:/about' => 'HomeController@showAboutUs',
    'GET:/contact' => 'HomeController@showContactUs',
    'GET:/view/forgot-password' => 'AuthController@showForgotPasswordPage',
    'POST:/forgot-password' => 'ForgotPasswordController@sendLink',
    'GET:/reset-password' => 'AuthController@showResetPasswordPage',
    'POST:/reset-password' => 'ForgotPasswordController@handleReset',


    //Admin
    'GET:/dashboard' => 'AdminController@showDashboard',
    'GET:/pending-orders' => 'Ordercontroller@getPendingOrders',
    'GET:/pending-orders/details/{id}' => 'OrderController@orderDetails',
    'GET:/ordered-list' => 'OrderController@getOrderedList',
    'POST:/orders/update-status' => 'OrderController@updatePendingOrderStatus',
    'POST:/orders/orders-status' => 'OrderController@updateOrderedStatus',
    'GET:/orders/pending' => 'OrderController@getOrderStatus',
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

    //BADGE
    'GET:/pending-orders/badge/count' => 'OrderController@getPendingCount',

    //DASHBOARD
    'GET:/sales/weekly' => 'SalesController@weeklySales',
    'GET:/sales/daily' => 'SalesController@dailySales',

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

    // Location
    'GET:/location/regions' => 'LocationController@getRegions',
    'GET:/location/province' => 'LocationController@getProvinces',
    'GET:/location/muncity' => 'LocationController@getMunicipalities',
    'GET:/location/barangay' => 'LocationController@getBarangays',




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