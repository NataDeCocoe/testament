<?php
global $routes;

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__.'/../config/routes.php';
require_once __DIR__.'/../app/controllers/BaseController.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


$matched = false;
foreach ($routes as $pattern => $handler) {

    $regex = str_replace('/', '\/', $pattern);
    $regex = preg_replace('/\{[^}]+\}/', '([^\/]+)', $regex);

    if (preg_match("/^{$regex}$/", "$requestMethod:$requestUri", $matches)) {
        $matched = true;
        list($controllerName, $methodName) = explode('@', $handler);

        require_once __DIR__."/../app/controllers/{$controllerName}.php";
        $controller = new $controllerName();

        array_shift($matches);
        if (is_callable([$controller, $methodName])) {
            call_user_func_array([$controller, $methodName], $matches);
        } else {
            header("HTTP/1.0 404 Not Found");
            echo "404 - Method not found";
            exit;
        }
    }
}

if (!$matched) {
    header("HTTP/1.0 404 Not Found");
    echo '404 - Page Not Found';
}