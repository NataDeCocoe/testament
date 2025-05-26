<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Cart.php';
require_once __DIR__ . '/../models/Order.php';

class PaymentController extends BaseController{
    private $cartModel;
    private $productModel;
    public function __construct(){
        $this->cartModel = new Cart();
        $this->productModel = new Product();
    }

    public function getOptions() {
        $paymentOptions = [
            [ 'id' => 'cod', 'label' => 'Cash on Delivery', 'default' => true ],
            [ 'id' => 'paypal', 'label' => 'PayPal', 'default' => false ]
        ];

        header('Content-Type: application/json');
        echo json_encode($paymentOptions);
    }
}
?>