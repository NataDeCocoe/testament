<?php

class BaseController{
    public function __construct(){

    }

    public function views($view, $data = []) {
        extract($data); // Makes $user, etc. available in the view

        // Remove leading slashes and build full path
        $view = ltrim($view, '/');
        $viewPath = __DIR__ . '/../views/' . $view . '.php';

        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die("View not found: $viewPath");
        }
    }

    protected function redirect($url){
        header("Location: {$url}");
        exit;
    }


    protected function Authenticated(){
        return isset($_SESSION['user_id']);
    }


}
?>