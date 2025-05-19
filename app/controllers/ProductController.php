<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Product.php';

class ProductController extends BaseController{

    public function getProducts(){
        $productModel = new Product();
        $products = $productModel->getAllProd();
        $this->views('admin/inventory', ['products' => $products]);
    }

    public function addProduct() {

        header('Content-Type: application/json');


        $maxPostSize = $this->parseSize(ini_get('post_max_size'));
        if ($_SERVER['CONTENT_LENGTH'] > $maxPostSize) {
            http_response_code(413);
            echo json_encode([
                'status' => 'error',
                'message' => 'Request exceeds maximum allowed size of ' . ini_get('post_max_size')
            ]);
            return;
        }


        try {
            $productModel = new Product();


            $prod_name = htmlspecialchars(trim($_POST['prod_name'] ?? ''));
            $prod_desc = htmlspecialchars(trim($_POST['prod_desc'] ?? ''));
            $prod_quan = (int)($_POST['prod_quan'] ?? 0);
            $prod_price = (float)($_POST['prod_price'] ?? 0.0);


            if (empty($prod_name)) throw new Exception("Product name is required");
            if (strlen($prod_name) > 100) throw new Exception("Product name too long (max 100 chars)");
            if (empty($prod_desc)) throw new Exception("Description is required");
            if ($prod_quan <= 0) throw new Exception("Quantity must be positive");
            if ($prod_price <= 0) throw new Exception("Price must be positive");


            if (empty($_FILES['prod_img']['tmp_name'])) {
                throw new Exception("No image file uploaded");
            }

            $prod_img = $this->handleImageUpload($_FILES['prod_img']);


            $created_at = date('Y-m-d H:i:s');
            $prod_code = mt_rand(100000, 999999);

            $result = $productModel->addProduct(
                $prod_code,
                $prod_name,
                $prod_desc,
                $prod_quan,
                $prod_price,
                $prod_img,
                $created_at
            );

            if (!$result) {
                throw new Exception("Database operation failed");
            }


            echo json_encode([
                'status' => 'success',
                'message' => 'Product added successfully',
                'product_code' => $prod_code,
                'image_path' => $prod_img
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }


    private function handleImageUpload($file) {
        $maxFileSize = 5 * 1024 * 1024;


        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errors = [
                UPLOAD_ERR_INI_SIZE => 'File exceeds server limit',
                UPLOAD_ERR_FORM_SIZE => 'File exceeds form limit',
                UPLOAD_ERR_PARTIAL => 'File partially uploaded',
                UPLOAD_ERR_NO_FILE => 'No file uploaded',
                UPLOAD_ERR_NO_TMP_DIR => 'Missing temp folder',
                UPLOAD_ERR_CANT_WRITE => 'Failed to write file',
                UPLOAD_ERR_EXTENSION => 'PHP extension blocked upload'
            ];
            throw new Exception($errors[$file['error']] ?? 'Unknown upload error');
        }


        if ($file['size'] > $maxFileSize) {
            throw new Exception('Image exceeds maximum allowed size of 5MB');
        }


        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);
        $allowedMimes = [
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif'
        ];

        if (!in_array($mime, $allowedMimes)) {
            throw new Exception('Invalid file type. Only JPG, PNG, and GIF are allowed');
        }


        $uploadsDir = __DIR__ . '/../../public/uploads/';
        if (!is_dir($uploadsDir)) {
            mkdir($uploadsDir, 0755, true);
        }


        $extension = array_search($mime, $allowedMimes);
        $filename = 'prod_' . bin2hex(random_bytes(8)) . '.' . $extension;
        $destination = $uploadsDir . $filename;


        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            throw new Exception('Failed to save uploaded file');
        }

        return 'uploads/' . $filename;
    }

    private function parseSize($size) {
        $unit = preg_replace('/[^bkmgtpezy]/i', '', $size);
        $size = preg_replace('/[^0-9\.]/', '', $size);
        if ($unit) {
            return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
        }
        return round($size);
    }





    public function show(){
        header('Content-Type: application/json');
        $response = ['status' => false, 'message' => '', 'data' => null];

        if (!isset($_GET['id'])) {
            $response['message'] = 'No product ID provided.';
            echo json_encode($response);
            return;
        }

        $id = $_GET['id'];
        $productModel = new Product();
        $product = $productModel->find($id);

        if ($product) {
            $response['status'] = true;
            $response['message'] = 'Product retrieved successfully.';
            $response['data'] = $product;
        } else {
            $response['message'] = 'Product not found.';
        }

        echo json_encode($response);
    }

    public function updateProduct()
    {
        header('Content-Type: application/json');
        ini_set('display_errors', 1); error_reporting(E_ALL);

        $response = ['status' => false, 'message' => ''];

        try {
            if (!isset($_POST['prod_id'])) {
                throw new Exception('Missing product ID');
            }

            $id = $_POST['prod_id'];
            $data = [
                'prod_name' => $_POST['prod_name'],
                'prod_desc' => $_POST['prod_desc'],
                'prod_quan' => $_POST['prod_quan'],
                'prod_price' => $_POST['prod_price'],
            ];


            $product = new Product();
            $success = $product->update($id, $data);

            if ($success) {
                $response['status'] = 'success';
                $response['message'] = 'Product updated successfully';
            } else {
                $response['message'] = 'Failed to update product';
            }
        } catch (Exception $e) {
            $response['message'] = 'Error: ' . $e->getMessage();
        }

        echo json_encode($response);
    }


    public function deleteProduct()
    {
        header('Content-Type: application/json');
        ini_set('display_errors', 1); error_reporting(E_ALL);

        $response = ['status' => false, 'message' => ''];

        try {
            if (!isset($_POST['prod_id'])) {
                throw new Exception('Product ID is required.');
            }

            $id = $_POST['prod_id'];
            $productModel = new Product();

            if ($productModel->delete($id)) {
                $response['status'] = true;
                $response['message'] = 'Product deleted';
            } else {
                $response['message'] = 'Failed to delete product';
            }

        } catch (Exception $e) {
            $response['message'] = 'Exception: ' . $e->getMessage();
        }

        echo json_encode($response);
    }

    public function countProducts()
    {
        header('Content-Type: application/json');

        try {
            $productModel = new Product();
            $total = $productModel->countAllProducts();

            echo json_encode([
                'status' => true,
                'count' => $total
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function getAllForNewRealease()
    {
        header('Content-Type: application/json');
        $response = ['status' => false, 'data' => [], 'message' => ''];

        try {
            $productModel = new Product();
            $products = $productModel->getLimited(4);

            if (!empty($products)) {
                $response['status'] = true;
                $response['data'] = $products;
            } else {
                $response['message'] = 'No products found.';
            }
        } catch (Exception $e) {
            $response['message'] = 'Error: ' . $e->getMessage();
        }

        echo json_encode($response);
    }

    public function getAllProducts()
    {
        $product = new Product();
        $products = $product->getAll();

        header('Content-Type: application/json');
        echo json_encode($products);
    }

    public function getAllProductsForCategories()
    {
        header('Content-Type: application/json');

        $productModel = new Product();
        $products = $productModel->getAll();

        echo json_encode(['status' => true, 'products' => $products]);
    }

    public function getProduct($id) {
        $productModel = new Product();
        $product = $productModel->find($id);

        if ($product) {
            echo json_encode([
                'status' => true,
                'data' => $product
            ]);
        } else {
            echo json_encode([
                'status' => false,
                'message' => 'Product not found.'
            ]);
        }
    }


}
?>