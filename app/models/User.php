<?php
require_once __DIR__ . '/../../config/database.php';

class User
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function create($firstname, $lastname, $email, $phone_num, $address, $password)
    {
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

    public function findByEmail($email)
    {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function checkRole($email)
    {
        $query = "SELECT role FROM users WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result['role'] : null;
    }

    public function findByPhone($phone)
    {
        $query = "SELECT * FROM users WHERE phone_num = :phone";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':phone', $phone);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function countAll()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM users");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;
    }

    public function saveResetToken($email, $hashedToken, $expiresAt)
    {
        $stmt = $this->db->prepare("
            INSERT INTO password_resets (email, token, expires_at)
            VALUES (:email, :token, :expires_at) ON DUPLICATE KEY UPDATE token = VALUES(token), expires_at = VALUES(expires_at)");
        return $stmt->execute([
            ':email' => $email,
            ':token' => $hashedToken,
            ':expires_at' => $expiresAt
        ]);
    }

    public function deleteTokensForEmail($email) {
        $stmt = $this->db->prepare("
            DELETE FROM password_resets 
            WHERE email = :email
        ");
        return $stmt->execute([':email' => $email]);
    }

    public function getResetTokenByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM password_resets WHERE email = :email");
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getResetEntry()
    {
        $stmt = $this->db->prepare("SELECT * FROM password_resets ORDER BY created_at DESC LIMIT 1");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUserPassword($email, $hashedPassword)
    {
        $stmt = $this->db->prepare(" UPDATE users SET password = :password WHERE email = :email");
        return $stmt->execute([
            ':email' => $email,
            ':password' => $hashedPassword
        ]);
    }

    public function deleteResetToken($email)
    {
        $stmt = $this->db->prepare("DELETE FROM password_resets WHERE email = :email");
        return $stmt->execute([':email' => $email]);
    }
}

?>