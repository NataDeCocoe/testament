<?php
require_once __DIR__ . '/../../config/database.php';

class Product
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();

    }

    public function addProduct($prod_code, $prod_name, $prod_desc, $prod_quan, $prod_price, $prod_img, $created_at, $category_id, $weight, $length, $width, $height){
        $query = "INSERT INTO products 
        (prod_code, prod_name, prod_desc, prod_quan, prod_price, prod_img,
         category_id, weight_kg, length_cm, width_cm, height_cm, created_at)
        VALUES 
        (:prod_code, :prod_name, :prod_desc, :prod_quan, :prod_price, :prod_img,
         :category_id, :weight, :length, :width, :height, :created_at)";


        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':prod_code', $prod_code);
        $stmt->bindParam(':prod_name', $prod_name);
        $stmt->bindParam(':prod_desc', $prod_desc);
        $stmt->bindParam(':prod_quan', $prod_quan);
        $stmt->bindParam(':prod_price', $prod_price);
        $stmt->bindParam(':prod_img', $prod_img);
        $stmt->bindParam(':created_at', $created_at);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':weight', $weight);
        $stmt->bindParam(':length', $length);
        $stmt->bindParam(':width', $width);
        $stmt->bindParam(':height', $height);

        return $stmt->execute();
    }

    public function getAllProd()
    {
        $query = "SELECT * FROM products ORDER BY created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE prod_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data)
    {
        $sql = "UPDATE products SET 
                    prod_name = :name, 
                    prod_desc = :desc,
                    prod_quan = :quan, 
                    prod_price = :price
                WHERE prod_id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':name', $data['prod_name']);
        $stmt->bindParam(':desc', $data['prod_desc']);
        $stmt->bindParam(':quan', $data['prod_quan']);
        $stmt->bindParam(':price', $data['prod_price']);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM products WHERE prod_id = ?");
        return $stmt->execute([$id]);
    }

    public function countAllProducts()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM products");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;
    }

    public function getLimited($limit)
    {
        $stmt = $this->db->prepare("SELECT * FROM products ORDER BY created_at DESC LIMIT :limit");
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT * FROM products ORDER BY created_at ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deductQuantity($productId, $quantity)
    {
        $stmt = $this->db->prepare("UPDATE products SET prod_quan = prod_quan - :qty WHERE prod_id = :pid");
        $stmt->execute([':qty' => $quantity, ':pid' => $productId]);
    }

    public function getProductPrice($productId)
    {
        $stmt = $this->db->prepare("SELECT prod_price FROM products WHERE prod_id = :pid");
        $stmt->execute([':pid' => $productId]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        return $product['price'];
    }
}

?>