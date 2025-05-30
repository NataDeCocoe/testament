<?php
require_once __DIR__ . '/../../config/database.php';

class Sales{

    private $db;

    public function __construct(){
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function addSale($orderId, $productId, $quantity, $price, $total) {
        $stmt = $this->db->prepare("INSERT INTO sales (order_id, product_id, quantity, price, total_price) VALUES (:order_id, :product_id, :quantity, :price, :total_price)");
        $stmt->execute([
            ':order_id' => $orderId,
            ':product_id' => $productId,
            ':quantity' => $quantity,
            ':price' => $price,
            ':total_price' => $total
        ]);
    }

    public function getWeeklySales() {
        // Get sales for the current week, grouped by day
        $query = "SELECT 
                    DAYNAME(sold_at) AS day_name,
                    DAYOFWEEK(sold_at) AS day_of_week,
                    SUM(total_price) AS daily_sales
                  FROM sales
                  WHERE YEARWEEK(sold_at, 1) = YEARWEEK(CURDATE(), 1)
                  GROUP BY day_name, day_of_week
                  ORDER BY day_of_week";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDailySales() {
        $query = "SELECT 
                    DAYOFWEEK(sold_at) AS day_of_week,
                    DATE_FORMAT(sold_at, '%a') AS day_short,
                    SUM(total_price) AS daily_sales
                  FROM sales
                  WHERE sold_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                  GROUP BY day_of_week, day_short
                  ORDER BY day_of_week";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error in getDailySales: " . $e->getMessage());
            throw $e;
        }
    }
}
?>