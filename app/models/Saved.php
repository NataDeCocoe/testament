<?php
require_once __DIR__ . '/../../config/database.php';

class Saved {
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public static function add($userId, $productId)
    {
        $db = (new Database())->getConnection();
        $stmt = $db->prepare("INSERT INTO saved_items (user_id, product_id) VALUES (:user_id, :product_id)");
        $stmt->execute([
            ':user_id' => $userId,
            ':product_id' => $productId
        ]);
    }

    public static function remove($userId, $productId)
    {
        $db = (new Database())->getConnection();
        $stmt = $db->prepare("DELETE FROM saved_items WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute([
            ':user_id' => $userId,
            ':product_id' => $productId
        ]);
    }

    public function toggleSaved($userId, $productId)
    {
        if ($this->isSaved($userId, $productId)) {
            $stmt = $this->db->prepare("DELETE FROM saved_items WHERE user_id = :user_id AND product_id = :product_id");
            $stmt->execute([
                'user_id' => $userId,
                'product_id' => $productId
            ]);
            return 'Removed';
        } else {
            $stmt = $this->db->prepare("INSERT INTO saved_items (user_id, product_id) VALUES (:user_id, :product_id)");
            $stmt->execute([
                'user_id' => $userId,
                'product_id' => $productId
            ]);
            return 'Saved';
        }
    }

    public function isSaved($userId, $productId)
    {
        $stmt = $this->db->prepare("SELECT * FROM saved_items WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute([
            'user_id' => $userId,
            'product_id' => $productId
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
    }

    public function getSavedItems($userId)
    {
        $sql = "SELECT 
                p.prod_id,
                p.prod_name,
                p.prod_img
            FROM saved_items s
            JOIN products p ON s.product_id = p.prod_id
            WHERE s.user_id = :user_id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>