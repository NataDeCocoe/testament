<?php
require_once __DIR__ . '/../../config/database.php';


class Notification {
    private $db;

    public function __construct() {
        $this->db = new Database;
        $this->db = $this->db->getConnection();

    }

    public function send($data) {
        $image = isset($data['img']) && !empty($data['img']) ? $data['img'] : null;


        date_default_timezone_set('Asia/Manila');

        $sql = "INSERT INTO notifications (user_id, title, message, img, created_at)
            VALUES (:user_id, :title, :message, :img, :created_at)";

        $stmt = $this->db->prepare($sql);

        $success = $stmt->execute([
            ':user_id' => $data['user_id'],
            ':title' => $data['title'],
            ':message' => $data['message'],
            ':img' => $image,
            ':created_at' => date('Y-m-d H:i:s')
        ]);

        return $success;
    }



    public function getUserNotifications($userId)
    {
        // 1. Mark unread notifications as read
        $updateSql = "UPDATE notifications SET status = 'read' WHERE user_id = :user_id AND status = 'unread'";
        $updateStmt = $this->db->prepare($updateSql);
        $updateStmt->execute([':user_id' => $userId]);

        // 2. Fetch all notifications for the user ordered by newest first
        $fetchSql = "SELECT title, message, img, created_at, status
                     FROM notifications
                     WHERE user_id = :user_id
                     ORDER BY created_at DESC";
        $fetchStmt = $this->db->prepare($fetchSql);
        $fetchStmt->execute([':user_id' => $userId]);

        return $fetchStmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUnreadCount($userId)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM notifications WHERE user_id = :user_id AND status = 'unread'");
        $stmt->execute([':user_id' => $userId]);
        return (int) $stmt->fetchColumn();
    }


}

?>