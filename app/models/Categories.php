<?php
require_once __DIR__ . '/../../config/database.php';


class Categories{

    private $db;

    public function __construct(){
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getAllCategories() {
        try {
            $query = "SELECT category_id, category_name FROM categories ORDER BY category_id ASC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }
}

?>