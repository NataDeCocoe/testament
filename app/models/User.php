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

    public function findAdminByEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email AND role = 'admin' LIMIT 1");
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByPhone($phone){
        $query = "SELECT * FROM users WHERE phone_num = :phone";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':phone', $phone);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>