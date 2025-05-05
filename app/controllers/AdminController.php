<?php

class AdminController extends BaseController{

    public function showDashboard(){
       $this->views('admin/dashboard');
    }
    public function showOrders(){
        $this->views('admin/orders');
    }

}?>