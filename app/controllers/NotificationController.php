<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Notification.php';
require_once __DIR__ . '/../models/User.php';

class NotificationController extends BaseController{

    private $notificationModel;
    private $userModel;

    public function __construct(){
        $this->notificationModel = new Notification();
        $this->userModel = new User();
    }

    public function sendFromForm()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');

            $title = trim($_POST['title'] ?? '');
            $message = trim($_POST['message'] ?? '');
            $user_id = (int) ($_POST['user_id'] ?? 0);

            if (!$title || !$message || !$user_id) {
                echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
                return;
            }

            $imagePath = null;
            if (!empty($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
                $uploadsDir = __DIR__ . '/../../public/uploads/';
                $fileTmp = $_FILES['img']['tmp_name'];
                $fileName = basename($_FILES['img']['name']);
                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                $allowed = ['jpg', 'jpeg', 'png', 'gif'];

                if (!in_array($fileExt, $allowed)) {
                    echo json_encode(['status' => 'error', 'message' => 'Unsupported image format']);
                    return;
                }

                $newFileName = uniqid('notif_', true) . '.' . $fileExt;
                $destination = $uploadsDir . $newFileName;

                if (!move_uploaded_file($fileTmp, $destination)) {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to upload image']);
                    return;
                }

                $imagePath = '/uploads/' . $newFileName;
            }

            $success = $this->notificationModel->send([
                'user_id' => $user_id,
                'title' => $title,
                'img' => $imagePath,
                'message' => $message
            ]);

            if ($success) {
                echo json_encode(['status' => 'success', 'message' => 'Notification sent']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to save notification']);
            }
        }
    }

    public function showNotifications()
    {


        if (!isset($_SESSION['user_id'])) {

            header('Location: /login');
            exit;
        }

        $userId = $_SESSION['user_id'];


        $notifications = $this->notificationModel->getUserNotifications($userId);


        $this->views('pages/notification', ['notifications' => $notifications]);
    }

    public function createForm()
    {
        $users = $this->userModel->getAll();
        $this->views('admin/createNotification', ['users' => $users]);
    }

    public function getUnreadCount()
    {
        header('Content-Type: application/json');

        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['count' => 0]);
            return;
        }

        $userId = $_SESSION['user_id'];
        $count = $this->notificationModel->getUnreadCount($userId);

        echo json_encode(['count' => $count]);
    }

}
?>