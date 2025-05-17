<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/User.php';

class UserController extends BaseController{

    public function countUsers()
    {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        header('Content-Type: application/json');

        try {
            $userModel = new User();
            $total = $userModel->countAll();

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

}
?>