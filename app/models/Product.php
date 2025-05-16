<?php
require_once __DIR__ . '/../../config/database.php';

class Product {
    private $db;
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function addProduct($prod_code, $prod_name, $prod_desc, $prod_quan, $prod_price, $prod_img, $created_at) {
        $query = "INSERT INTO products 
    (prod_code, prod_name, prod_desc, prod_quan, prod_price, prod_img, created_at)
    VALUES (:prod_code, :prod_name, :prod_desc, :prod_quan, :prod_price, :prod_img, :created_at)";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':prod_code', $prod_code);
        $stmt->bindParam(':prod_name', $prod_name);
        $stmt->bindParam(':prod_desc', $prod_desc);
        $stmt->bindParam(':prod_quan', $prod_quan);
        $stmt->bindParam(':prod_price', $prod_price);
        $stmt->bindParam(':prod_img', $prod_img);
        $stmt->bindParam(':created_at', $created_at);

        return $stmt->execute();
    }

    public function getAllProd(){
        $query = "SELECT * FROM products";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>