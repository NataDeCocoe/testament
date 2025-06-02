<?php

require_once 'BaseController.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Cart.php';
require_once __DIR__ . '/../models/Order.php';
require_once '../app/helpers/ShippingCalculator.php';

class OrderController extends BaseController{
    private $cartModel;
    private $db;
    private $productModel;
    public function __construct(){
        $this->cartModel = new Cart();
        $this->productModel = new Product();

        $database = new Database();
        $this->db = $database->getConnection();

    }

    public function getPendingOrders(){
        $orderModel = new Order();
        $orders = $orderModel->getAllPendingOrders();


        $this->views('admin/pending', ['orders' => $orders]);
    }

    public function getOrderedList(){
        $orderModel = new Order();
        $orders = $orderModel->getAllOrders();


        $this->views('admin/orders', ['orders' => $orders]);
    }

    public function getPendingCount() {
        header('Content-Type: application/json');

        try {
            $orderModel = new Order();
            $count = $orderModel->getPendingCount();
            echo json_encode([
                'success' => true,
                'count' => $count
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function place() {
        header('Content-Type: application/json');
        // Ensure this path is correct

        try {
            // Get and validate input
            $data = json_decode(file_get_contents("php://input"), true);
            if (!$data) {
                throw new Exception("Invalid JSON input");
            }

            error_log("Order payload: " . print_r($data, true));

            // Required fields validation
            $required = [
                'firstName', 'lastName', 'phone',
                'region_code', 'province_code', 'muncity_id', 'barangay_code',
                'building', 'zip', 'courier', 'payment_method',
                'subtotal', 'total', 'items'
            ];

            foreach ($required as $field) {
                if (empty($data[$field]) || $data[$field] === 'undefined') {
                    throw new Exception("Missing required field: $field");
                }
            }

            // Validate items
            if (!is_array($data['items']) || count($data['items']) === 0) {
                throw new Exception("No items in order");
            }

            // Prepare items and validate format
            $items = array_map(function($item) {
                if (empty($item['product_id']) || empty($item['quantity']) || empty($item['price'])) {
                    throw new Exception("Invalid item format");
                }
                return [
                    'product_id' => $item['product_id'],
                    'quantity' => (int)$item['quantity'],
                    'price' => (float)$item['price'],
                    'reduce_stock' => $item['reduce_stock'] ?? true
                ];
            }, $data['items']);

            // Calculate shipping fee based on region and product details
            $destinationRegion = $data['region_code'];
            $shippingFee = ShippingCalculator::calculate($items, $destinationRegion, $this->db);

            // Prepare order data
            $orderModel = new Order();
            $orderData = [
                'user_id' => $_SESSION['user_id'] ?? 1,
                'ord_fname' => $data['firstName'],
                'ord_lname' => $data['lastName'],
                'contact_number' => $data['phone'],
                'region_code' => $data['region_code'],
                'province_code' => $data['province_code'],
                'muncity_id' => (int)$data['muncity_id'],
                'barangay_code' => $data['barangay_code'],
                'building_address' => $data['building'],
                'zip_code' => $data['zip'],
                'courier' => $data['courier'],
                'shipping_fee' => $shippingFee,
                'payment_method' => $data['payment_method'],
                'subtotal' => (float)$data['subtotal'],
                'total_amount' => (float)$data['subtotal'] + $shippingFee,
                'order_status' => 'pending',
                'payment_status' => 'Unpaid'
            ];

            // Create order
            $result = $orderModel->create($orderData, $items);

            if (isset($result['success']) && $result['success']) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Order placed successfully',
                    'order_id' => $result['order_id']
                ]);
            } else {
                throw new Exception($result['error'] ?? 'Order creation failed');
            }

        } catch (Exception $e) {
            error_log("Order Error: " . $e->getMessage());
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }


    public function countOrders(){
        header('Content-Type: application/json');

        try {
            $orderModel = new Order();
            $total = $orderModel->countAllOrders();

            echo json_encode([
                'status' => true,
                'count' => $total
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function orderDetails($id) {
        $orderModel = new Order();
        $data = $orderModel->getOrderWithProducts($id);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function updatePendingOrderStatus()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $orderId = $data['order_id'];
        $status = $data['status'];

        if (!in_array($status, ['approved', 'rejected'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid status']);
            return;
        }

        $orderModel = new Order();
        $success = $orderModel->updateAndProcessOrder($orderId, $status);

        echo json_encode(['success' => $success]);
    }

    public function updateOrderedStatus()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $orderId = $data['order_id'];
        $field = $data['field'];
        $value = $data['value'];

        $allowedFields = ['order_status', 'payment_status'];
        if (!in_array($field, $allowedFields)) {
            echo json_encode(['success' => false, 'message' => 'Invalid field']);
            return;
        }

        $orderModel = new Order();
        $result = $orderModel->updateStatus($orderId, $field, $value);

        echo json_encode(['success' => $result]);
    }

}
?>