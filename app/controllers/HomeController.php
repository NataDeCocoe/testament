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

    public function showHomePage(){
        $this->views('pages/home');
    }
    public function showCategory(){
        $this->views('pages/categories');
    }
    public function showSaved(){
        $this->views('pages/saved');
    }
    public function showMyOrders(){
        $this->views('pages/myOrders');
    }
    public function showNotification(){
        $this->views('pages/notification');
    }
    public function showProfile(){
        $this->views('pages/profile');
    }

    public function showCart(){
        $this->views('pages/cart');
    }

    public function showCheckout(){
        $this->views('checkout/checkout');
    }

    public function showSuccess(){
        $this->views('checkout/success');
    }

}

?>