<?php

require_once 'BaseController.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Cart.php';
require_once __DIR__ . '/../models/Order.php';

class OrderController extends BaseController{
    private $cartModel;
    private $productModel;
    public function __construct(){
        $this->cartModel = new Cart();
        $this->productModel = new Product();

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

    public function place(){
        header('Content-Type: application/json');
        $body = json_decode(file_get_contents("php://input"), true);

        if (!$body) {
            error_log("Invalid JSON received");
            http_response_code(400);
            echo json_encode(["success" => false, "message" => "Invalid JSON"]);
            exit;
        }

        error_log("Order payload: " . print_r($body, true));


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            file_put_contents('log_order.txt', print_r($data, true));
            if (!$data) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'Invalid JSON']);
                return;
            }
            $required = ['firstName', 'lastName', 'phone', 'address', 'zip'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    http_response_code(400);
                    echo json_encode(['status' => 'error', 'message' => "Missing required field: $field"]);
                    return;
                }
            }

            $orderModel = new Order();

            $orderData = [
                'user_id' => $_SESSION['user_id'] ?? 1,
                'ord_fname' => $data['firstName'] ?? null,
                'ord_lname' => $data['lastName'] ?? null,
                'contact_number' => $data['phone'],
                'delivery_address' => $data['address'],
                'building_address' => $data['building'],
                'zip_code' => $data['zip'],
                'courier' => $data['courier'],
                'shipping_fee' => floatval($data['shipping_fee']),
                'payment_method' => $data['payment_method'],
                'subtotal' => floatval($data['subtotal']),
                'total_amount' => floatval($data['total']),
                'shipping_status' => 'Processing',
                'payment_status' => 'Unpaid',
                'ordered_at' => date('m-d-Y h:i A')
            ];

            $items = $data['items'] ?? [];

            $result = $orderModel->create($orderData, $items);

            if ($result === true) {
                echo json_encode(['status' => 'success', 'message' => 'Order placed successfully']);
            } else {
                http_response_code(500);
                echo json_encode([
                    'status' => 'error',
                    'message' => $result
                ]);
            }
        } else {
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
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

    public function updatePendingOrderStatus(){
        $data = json_decode(file_get_contents("php://input"), true);

        $orderId = $data['order_id'];
        $status = $data['status'];

        if (!in_array($status, ['approved', 'rejected'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid status']);
            return;
        }

        $orderModel = new Order();
        $success = $orderModel->updateOrderStatus($orderId, $status);

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