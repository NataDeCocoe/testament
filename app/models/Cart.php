<?php
require_once __DIR__ . '/../../config/database.php';

class Cart{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();

    }

    public function getCartItems() {
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            error_log("No user_id in session. Session data: " . print_r($_SESSION, true));
            return [];
        }

        $stmt = $this->db->prepare("
        SELECT 
            c.cart_id, 
            c.quantity, 
            p.prod_id,
            p.prod_name, 
            p.prod_price, 
            p.prod_img
        FROM cart c
        JOIN products p ON c.product_id = p.prod_id
        WHERE c.user_id = ?
    ");

        $stmt->execute([$userId]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        error_log("Cart items query results for user $userId: " . print_r($results, true));

        return $results;
    }


    public function addToCart($product_id, $quantity)
    {
        $user_id = $_SESSION['user_id'] ?? 1;

        // Check if the product already exists in cart
        $stmt = $this->db->prepare("SELECT cart_id, quantity FROM cart WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$user_id, $product_id]);
        $existing = $stmt->fetch();

        if ($existing) {
            // Update quantity if product exists
            $newQuantity = $existing['quantity'] + $quantity;
            $updateStmt = $this->db->prepare("UPDATE cart SET quantity = ? WHERE cart_id = ?");
            return $updateStmt->execute([$newQuantity, $existing['cart_id']]);
        } else {
            // Insert new product to cart
            $insertStmt = $this->db->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
            return $insertStmt->execute([$user_id, $product_id, $quantity]);
        }
    }


    public function countItems()
    {
        $user_id = $_SESSION['user_id'] ?? 1;
        $stmt = $this->db->prepare("SELECT SUM(quantity) as total FROM cart WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $row = $stmt->fetch();
        return $row ? (int) $row['total'] : 0;
    }

    public function removeItem($cartId) {
        $stmt = $this->db->prepare("DELETE FROM cart WHERE cart_id = ? AND user_id = ?");
        return $stmt->execute([$cartId, $_SESSION['user_id']]);
    }

    public function updateQuantity($userId, $cartId, $quantity)
    {
        $stmt = $this->db->prepare("UPDATE cart SET quantity = ? WHERE cart_id = ? AND user_id = ?");
        return $stmt->execute([$quantity, $cartId, $userId]);
    }

    public function clearCartByUserId($userId){
        $sql = "DELETE FROM cart WHERE user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }

}
?>