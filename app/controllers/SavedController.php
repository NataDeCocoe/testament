<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Saved.php';


class SavedController extends BaseController{

    private $savedModel;
    private $productModel;
    public function __construct(){
        $this->savedModel = new Saved;
        $this->productModel = new Product;
    }
    public function toggle()
    {
        $userId = $_SESSION['user_id'] ?? null;
        $productId = $_POST['product_id'] ?? null;

        if (!$userId || !$productId) {
            http_response_code(400);
            echo json_encode(['message' => 'Invalid input']);
            return;
        }

        $status = $this->savedModel->toggleSaved($userId, $productId);
        echo json_encode(['message' => $status]);
    }

    public function getUserSaved()
    {
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            echo json_encode([]);
            return;
        }

        $items = $this->savedModel->getSavedItems($userId);
        echo json_encode($items);
    }
}

?>