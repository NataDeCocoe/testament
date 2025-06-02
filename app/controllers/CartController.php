<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Cart.php';

class CartController extends BaseController{

    private $cartModel;

    public function __construct(){
        $this->cartModel = new Cart();
    }

    public function add(){

        $input = json_decode(file_get_contents('php://input'), true);

        $product_id = $input['product_id'] ?? null;
        $quantity = $input['quantity'] ?? 1;


        if (!$product_id) {
            echo json_encode([
                'status' => false,
                'message' => 'Product ID is required.'
            ]);
            return;
        }


        $cartModel = new Cart();
        $success = $cartModel->addToCart($product_id, $quantity);

        if ($success) {

            $count = $cartModel->countItems();
            echo json_encode([
                'status' => true,
                'message' => 'Product added to cart!',
                'cartCount' => $count
            ]);
        } else {
            echo json_encode([
                'status' => false,
                'message' => 'Failed to add product to cart.'
            ]);
        }
    }


    public function count() {
        $cartModel = new Cart();
        echo json_encode(['status' => true, 'count' => $cartModel->countItems()]);
    }

    public function view() {
        $cartModel = new Cart();
        $items = $cartModel->getCartItems();


        $formattedItems = array_map(function($item) {
            return [
                'id' => $item['cart_id'],
                'name' => $item['prod_name'],
                'quantity' => $item['quantity'],
                'price' => (float)$item['prod_price'],
                'image' => $item['prod_img']
            ];
        }, $items);

        echo json_encode(['status' => true, 'items' => $formattedItems]);
    }

    public function remove($id) {
        $cartModel = new Cart();
        $success = $cartModel->removeItem($id); // returns true/false

        if ($success) {
            echo json_encode(['status' => true, 'message' => 'Item removed from cart.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Failed to remove item.']);
        }
    }

    public function getItems() {
        header('Content-Type: application/json');

        try {
            $cartModel = new Cart();
            $items = $cartModel->getCartItems();


            $processedItems = array_map(function($item) {
                return [
                    'id' => $item['cart_id'],
                    'product_id' => $item['prod_id'],
                    'prod_id' => $item['prod_id'],
                    'prod_name' => $item['prod_name'],
                    'prod_price' => (float)$item['prod_price'],
                    'quantity' => (int)$item['quantity'],
                    'prod_img' => $item['prod_img'],
                    'weight' => $item['weight_kg'],
                    'length' => $item['length_cm'],
                    'width' => $item['width_cm'],
                    'height' => $item['height_cm'],
                ];
            }, $items);

            echo json_encode([
                'status' => true,
                'items' => $processedItems
            ]);

        } catch (Exception $e) {
            error_log("Error in getItems: " . $e->getMessage());
            echo json_encode([
                'status' => false,
                'message' => 'Failed to load cart items',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function updateCartQuantity($id)
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $newQty = $input['quantity'] ?? 1;


        $userId = $_SESSION['user_id'];


        $cartModel = new Cart();
        $updated = $cartModel->updateQuantity($userId, $id, $newQty);

        if ($updated) {
            echo json_encode(['status' => true, 'message' => 'Cart updated']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Update failed']);
        }
    }

    public function clearAfterCheckout(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id'] ?? 1;

            $cartModel = new Cart();
            $result = $cartModel->clearCartByUserId($userId);

            if ($result) {
                echo json_encode(['status' => 'success']);
            } else {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Failed to clear cart']);
            }
        }
    }

}
?>