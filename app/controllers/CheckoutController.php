<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Cart.php';

class CheckoutController extends BaseController{
    private $cartModel;

    public function __construct(){
        $this->cartModel = new Cart();
    }

    public function fetch()
    {
        header('Content-Type: application/json');

        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['error' => 'User not logged in']);
            return;
        }

        $userId = $_SESSION['user_id'];

        $stmt = $this->db->prepare("
        SELECT 
            c.quantity, 
            p.productName, 
            p.price, 
            p.image 
        FROM cart c
        JOIN products p ON c.productCode = p.productCode
        WHERE c.user_id = ?
    ");
        $stmt->execute([$userId]);
        $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($cartItems);
    }

}
?>