<?php

require_once 'BaseController.php';
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../models/User.php';

class ProfileController extends BaseController {
    public function showProfile() {

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $userModel = new User();
        $user = $userModel->findById($_SESSION['user_id']);

        $this->views('pages/profile', ['user' => $user]);

    }
}


?>