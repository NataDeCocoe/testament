<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Product.php';
class AdminController extends BaseController{

    public function showDashboard(){
        $this->views('admin/dashboard');
    }
    public function showPendingOrders(){
        $this->views('admin/pending');
    }
    public function showOrders(){
        $this->views('admin/orders');
    }

    public function showInventory(){
        $this->views('admin/inventory');
    }

    public function showCreateNotification(){
        $this->views('admin/createNotification');
    }

}?>