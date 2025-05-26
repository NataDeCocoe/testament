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
            c.id, 
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


        $stmt = $this->db->prepare("SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$user_id, $product_id]);
        $existing = $stmt->fetch();

        if ($existing) {

            $newQuantity = $existing['quantity'] + $quantity;
            $updateStmt = $this->db->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
            return $updateStmt->execute([$newQuantity, $existing['id']]);
        } else {

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
        $stmt = $this->db->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
        return $stmt->execute([$cartId, $_SESSION['user_id']]);
    }

    public function updateQuantity($userId, $cartId, $quantity)
    {
        $stmt = $this->db->prepare("UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ?");
        return $stmt->execute([$quantity, $cartId, $userId]);
    }


}
?>