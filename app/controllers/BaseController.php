<?php

class BaseController{
    public function __construct(){

    }

    protected function views($view, $data = []){
        extract($data);
        require_once __DIR__."/../views/{$view}.php";
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