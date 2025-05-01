<?php

class HomeController extends BaseController{

    public function index(){
        $this->views('landing/about');
    }
    public function showAboutUs(){
        $this->views('landing/about');
    }
    public function showContactUs(){
        $this->views('landing/contact');
    }
}

?>