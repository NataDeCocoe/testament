<?php
require_once __DIR__ . '/../../config/database.php';

class User {
    private $db;
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function create($firstname, $lastname, $email, $phone_num, $address, $password){
        $query = 'INSERT INTO users (firstname, lastname, email, phone_num, home_address, password) VALUES (:firstname, :lastname, :email, :phone_num, :home_address, :password)';
        $stmt = $this->db->prepare($query);

        $stmt->bindParam('firstname', $firstname);
        $stmt->bindParam('lastname', $lastname);
        $stmt->bindParam('email', $email);
        $stmt->bindParam('phone_num', $phone_num);
        $stmt->bindParam('home_address', $address);
        $stmt->bindParam('password', $password);

        return $stmt->execute();

    }

    public function findByEmail($email) {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function checkRole($email) {
        $query = "SELECT role FROM users WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result['role'] : null;
    }

    public function findByPhone($phone){
        $query = "SELECT * FROM users WHERE phone_num = :phone";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':phone', $phone);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>