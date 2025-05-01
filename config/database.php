<?php

class Database {
    private $host = "localhost";
    private $db_name = "testamentdb";
    private $user = "root";
    private $password = "";
    private $conn;


    public function getConnection() {
        $this->conn = null;

        try{
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db_name}",
                $this->user,
                $this->password
            );
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e){
            echo "Connection failed: " . $e->getMessage();
        }
        return $this->conn;
    }
}


?>