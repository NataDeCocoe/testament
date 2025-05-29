<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

global $routes;

session_start();
date_default_timezone_set('UTC');
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

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
if ($_SERVER['REQUEST_URI'] === '/logout') {
    require_once '../app/controllers/AuthController.php';
    $controller = new AuthController();
    $controller->logout();
}




if (!$matched) {
    header("HTTP/1.0 404 Not Found");
    echo '404 - Page Not Found';
}