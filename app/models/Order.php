<?php
require_once __DIR__ . '/../../config/database.php';

class Order {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getPendingCount() {
        $query = "SELECT COUNT(*) AS pending_count FROM orders 
                 WHERE order_status = 'pending' AND 
                 ordered_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int)$result['pending_count'];
        } catch (PDOException $e) {
            error_log("Database error in getPendingCount: " . $e->getMessage());
            return 0; // Return 0 if there's an error
        }
    }

    public function create($orderData, $items) {
        try {
            // Verify database connection
            if (!$this->db) {
                throw new Exception("Database connection failed");
            }

            $this->db->beginTransaction();

            // 1. Insert order
            $query = "
        INSERT INTO orders (
            user_id, ord_fname, ord_lname, contact_number,
            region_code, province_code, muncity_id, barangay_code,
            building_address, zip_code,
            courier, shipping_fee, payment_method,
            subtotal, total_amount, order_status, payment_status
        ) VALUES (
            :user_id, :ord_fname, :ord_lname, :contact_number,
            :region_code, :province_code, :muncity_id, :barangay_code,
            :building_address, :zip_code,
            :courier, :shipping_fee, :payment_method,
            :subtotal, :total_amount, :order_status, :payment_status
        )";

            $stmt = $this->db->prepare($query);
            if (!$stmt) {
                throw new Exception("Failed to prepare order statement: " . implode(' ', $this->db->errorInfo()));
            }

            $executed = $stmt->execute([
                ':user_id' => $orderData['user_id'] ?? null,
                ':ord_fname' => $orderData['ord_fname'] ?? '',
                ':ord_lname' => $orderData['ord_lname'] ?? '',
                ':contact_number' => $orderData['contact_number'] ?? '',
                ':region_code' => $orderData['region_code'] ?? '',
                ':province_code' => $orderData['province_code'] ?? '',
                ':muncity_id' => $orderData['muncity_id'] ?? 0,
                ':barangay_code' => $orderData['barangay_code'] ?? '',
                ':building_address' => $orderData['building_address'] ?? '',
                ':zip_code' => $orderData['zip_code'] ?? '',
                ':courier' => $orderData['courier'] ?? '',
                ':shipping_fee' => $orderData['shipping_fee'] ?? 0,
                ':payment_method' => $orderData['payment_method'] ?? '',
                ':subtotal' => $orderData['subtotal'] ?? 0,
                ':total_amount' => $orderData['total_amount'] ?? 0,
                ':order_status' => $orderData['order_status'] ?? 'pending',
                ':payment_status' => $orderData['payment_status'] ?? 'Unpaid'
            ]);

            if (!$executed) {
                throw new Exception("Failed to execute order insertion: " . implode(' ', $stmt->errorInfo()));
            }

            $orderId = $this->db->lastInsertId();

            // 2. Validate and insert items
            foreach ($items as $item) {
                // Get complete product details
                $product = $this->db->prepare("
                SELECT prod_name, prod_code, weight_kg, length_cm, width_cm, height_cm 
                FROM products 
                WHERE prod_id = ?
            ");

                if (!$product->execute([$item['product_id'] ?? 0])) {
                    throw new Exception("Product query failed: " . implode(' ', $product->errorInfo()));
                }

                $productData = $product->fetch(PDO::FETCH_ASSOC);

                if (!$productData) {
                    throw new Exception("Product ID {$item['product_id']} does not exist");
                }

                // Calculate subtotal
                $subtotal = ($item['quantity'] ?? 0) * ($item['price'] ?? 0);

                // Insert order item
                $stmtItem = $this->db->prepare("
                INSERT INTO ordered_items (
                    order_id, prod_id, product_name, product_code,
                    quantity, price, subtotal,
                    weight_kg, length_cm, width_cm, height_cm
                ) VALUES (
                    :order_id, :prod_id, :product_name, :product_code,
                    :quantity, :price, :subtotal,
                    :weight_kg, :length_cm, :width_cm, :height_cm
                )
            ");

                if (!$stmtItem) {
                    throw new Exception("Failed to prepare item statement: " . implode(' ', $this->db->errorInfo()));
                }

                $itemExecuted = $stmtItem->execute([
                    ':order_id' => $orderId,
                    ':prod_id' => $item['product_id'],
                    ':product_name' => $productData['prod_name'],
                    ':product_code' => $productData['prod_code'],
                    ':quantity' => $item['quantity'] ?? 0,
                    ':price' => $item['price'] ?? 0,
                    ':subtotal' => $subtotal,
                    ':weight_kg' => $productData['weight_kg'],
                    ':length_cm' => $productData['length_cm'],
                    ':width_cm' => $productData['width_cm'],
                    ':height_cm' => $productData['height_cm']
                ]);

                if (!$itemExecuted) {
                    throw new Exception("Failed to insert order item: " . implode(' ', $stmtItem->errorInfo()));
                }

                // Update product stock if needed
                if (isset($item['reduce_stock']) && $item['reduce_stock']) {
                    $update = $this->db->prepare("
                    UPDATE products SET prod_quan = GREATEST(0, prod_quan - ?) 
                    WHERE prod_id = ?
                ");
                    if (!$update->execute([$item['quantity'], $item['product_id']])) {
                        throw new Exception("Stock update failed: " . implode(' ', $update->errorInfo()));
                    }
                }
            }

            $this->db->commit();
            return [
                'success' => true,
                'order_id' => $orderId,
                'order_status' => $orderData['order_status'] ?? 'pending'
            ];

        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Order Error: " . $e->getMessage());
            return [
                'success' => false,
                'error' => 'Database error: ' . $e->getMessage()
            ];
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Order Processing Error: " . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    public function countAllOrders(){
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM orders");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;
    }

    public function getAllPendingOrders(){
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE order_status = 'pending' ORDER BY ordered_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderWithProducts($orderId) {

        $stmt = $this->db->prepare("SELECT * FROM orders WHERE order_id = ?");
        $stmt->execute([$orderId]);
        $order = $stmt->fetch();


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

    public function getAllOrders(){
        $stmt = $this->db->prepare("SELECT * FROM orders 
                              WHERE order_status IN ('approved', 'processing', 'shipped', 'completed', 'cancelled') 
                              ORDER BY ordered_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateOrderStatus($orderId, $status){
        $stmt = $this->db->prepare("UPDATE orders SET order_status = ? WHERE order_id = ?");
        return $stmt->execute([$status, $orderId]);
    }

    public function updateStatus($orderId, $field, $value){
        $sql = "UPDATE orders SET $field = :value WHERE order_id = :order_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'value' => $value,
            'order_id' => $orderId
        ]);
    }

    public function updateAndProcessOrder($orderId, $status)
    {
        if ($status === 'approved') {
            // Get ordered items
            $items = $this->getOrderItems($orderId);

            // Check stock availability for all items first
            foreach ($items as $item) {
                $productId = $item['product_id'];
                $quantity = $item['quantity'];

                // Get current stock
                $stockStmt = $this->db->prepare("SELECT prod_quan FROM products WHERE prod_id = :pid");
                $stockStmt->execute([':pid' => $productId]);
                $currentStock = (int) $stockStmt->fetchColumn();

                if ($quantity > $currentStock) {
                    // Not enough stock, stop processing and return error or false
                    // You could throw an exception or return false here
                    return false;
                }
            }

            // If all stock checks passed, update order status
            $stmt = $this->db->prepare("UPDATE orders SET order_status = :status WHERE order_id = :order_id");
            $stmt->execute([
                ':status' => $status,
                ':order_id' => $orderId
            ]);

            // Deduct stock and insert into sales
            foreach ($items as $item) {
                $productId = $item['product_id'];
                $quantity = $item['quantity'];

                // Deduct product quantity
                $deduct = $this->db->prepare("UPDATE products SET prod_quan = prod_quan - :qty WHERE prod_id = :pid");
                $deduct->execute([':qty' => $quantity, ':pid' => $productId]);

                // Get product price
                $priceStmt = $this->db->prepare("SELECT prod_price FROM products WHERE prod_id = :pid");
                $priceStmt->execute([':pid' => $productId]);
                $price = $priceStmt->fetchColumn();

                $total = $price * $quantity;

                // Insert into sales
                $sale = $this->db->prepare("INSERT INTO sales (order_id, product_id, quantity, price, total_price) 
                                    VALUES (:oid, :pid, :qty, :price, :total)");
                $sale->execute([
                    ':oid' => $orderId,
                    ':pid' => $productId,
                    ':qty' => $quantity,
                    ':price' => $price,
                    ':total' => $total
                ]);
            }
        } else {
            // Just update status if not approved
            $stmt = $this->db->prepare("UPDATE orders SET order_status = :status WHERE order_id = :order_id");
            $stmt->execute([
                ':status' => $status,
                ':order_id' => $orderId
            ]);
        }

        return true;
    }



    public function getOrderItems($orderId)
    {
        $stmt = $this->db->prepare("SELECT * FROM ordered_items WHERE order_id = :order_id");
        $stmt->execute([':order_id' => $orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>