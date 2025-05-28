<?php
require_once __DIR__ . '/../../config/database.php';

class Order {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function create($orderData, $items){

        try {
            $this->db->beginTransaction();

            error_log("Order data: " . print_r($orderData, true));
            error_log("Order items: " . print_r($items, true));

            $query = ("
            INSERT INTO orders (
                user_id, ord_fname, ord_lname, contact_number, delivery_address, building_address, 
                zip_code, courier, shipping_fee, payment_method, subtotal, total_amount, ordered_at
            ) VALUES (
                :user_id, :ord_fname, :ord_lname, :contact_number, :delivery_address, :building_address, 
                :zip_code, :courier, :shipping_fee, :payment_method, :subtotal, :total_amount, NOW()
            )
        ");

            $stmt = $this->db->prepare($query);

            $stmt->execute([
                ':user_id' => $orderData['user_id'],
                ':ord_fname' => $orderData['ord_fname'],
                ':ord_lname' => $orderData['ord_lname'],
                ':contact_number' => $orderData['contact_number'],
                ':delivery_address' => $orderData['delivery_address'],
                ':building_address' => $orderData['building_address'],
                ':zip_code' => $orderData['zip_code'],
                ':courier' => $orderData['courier'],
                ':shipping_fee' => $orderData['shipping_fee'],
                ':payment_method' => $orderData['payment_method'],
                ':subtotal' => $orderData['subtotal'],
                ':total_amount' => $orderData['total_amount']
            ]);

            $orderId = $this->db->lastInsertId();

            foreach ($items as $item) {
                $check = $this->db->prepare("SELECT COUNT(*) FROM products WHERE prod_id = ?");
                $check->execute([$item['product_id']]);
                if ($check->fetchColumn() == 0) {
                    throw new Exception("Product ID {$item['product_id']} does not exist");
                }
            }

            foreach ($items as $item) {
                $stmtItem = $this->db->prepare("
                    INSERT INTO ordered_items (order_id, product_id, quantity, price)
                    VALUES (:order_id, :product_id, :quantity, :price)
                ");
                $stmtItem->execute([
                    ':order_id' => $orderId,
                    ':product_id' => $item['product_id'], // Changed from 'id'
                    ':quantity' => $item['quantity'],
                    ':price' => $item['price'] // Changed from 'prod_price'
                ]);
            }

            $this->db->commit();
            return true;

        } catch (PDOException $e) {
            $this->db->rollBack();
            return 'Order Transaction Failed: ' . $e->getMessage(); // helpful for debugging
        }
    }

    public function countAllOrders(){
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM orders");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;
    }

    public function getAllOrders(){
        $stmt = $this->db->prepare("SELECT * FROM orders ORDER BY ordered_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderWithProducts($orderId) {
        // Get the order info
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE order_id = ?");
        $stmt->execute([$orderId]);
        $order = $stmt->fetch();

        // Get the ordered products
        $productsStmt = $this->db->prepare("
            SELECT 
                p.prod_name AS product_name,
                p.prod_price,
                oi.quantity,
                (oi.quantity * p.prod_price) AS total_price
            FROM ordered_items oi
            JOIN products p ON oi.product_id = p.prod_id
            WHERE oi.order_id = ?
        ");
        $productsStmt->execute([$orderId]);
        $products = $productsStmt->fetchAll();

        return [
            'order' => $order,
            'products' => $products
        ];
    }

}
?>