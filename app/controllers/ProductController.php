<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Product.php';

class ProductController extends BaseController{

    public function getProducts(){
        $productModel = new Product();
        $products = $productModel->getAllProd();
        $this->views('admin/inventory', ['products' => $products]);
    }

}

?>