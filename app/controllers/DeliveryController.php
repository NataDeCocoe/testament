<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Cart.php';

class DeliveryController extends BaseController{
    private $cartModel;
    private $productModel;
    public function __construct(){
        $this->cartModel = new Cart();
        $this->productModel = new Product();
    }

    public function getOptions() {
        $deliveryOptions = [
            [
                'id' => 'j&t-express',
                'label' => 'J&T Express',
                'logo' => 'jnt.png',
                'default' => true
            ]
        ];

        header('Content-Type: application/json');
        echo json_encode($deliveryOptions);
    }
}
?>