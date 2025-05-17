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
        $response = ['status' => false, 'message' => ''];
        try {
            $productModel = new Product();

            $prod_name = $_POST['prod_name'] ?? '';
            $prod_desc = $_POST['prod_desc'] ?? '';
            $prod_quan = $_POST['prod_quan'] ?? 0;
            $prod_price = $_POST['prod_price'] ?? 0.0;
            $prod_img_path = null;


            if (!empty($_FILES['prod_img']['tmp_name'])) {
                if ($_FILES['prod_img']['error'] !== UPLOAD_ERR_OK) {
                    $uploadErrors = [
                        UPLOAD_ERR_INI_SIZE => 'File exceeds upload_max_filesize',
                        UPLOAD_ERR_FORM_SIZE => 'File exceeds form max size',
                        UPLOAD_ERR_PARTIAL => 'File only partially uploaded',
                        UPLOAD_ERR_NO_FILE => 'No file uploaded',
                        UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary directory',
                        UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
                        UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the upload'
                    ];
                    throw new Exception($uploadErrors[$_FILES['prod_img']['error']] ?? 'Unknown upload error');
                }

                $uploadsDir = __DIR__ . '/../../public/uploads/';
                if (!is_dir($uploadsDir)) {
                    mkdir($uploadsDir, 0755, true);
                }

                $originalName = basename($_FILES['prod_img']['name']);
                $extension = pathinfo($originalName, PATHINFO_EXTENSION);
                $uniqueName = uniqid('prod_', true) . '.' . $extension;
                $targetPath = $uploadsDir . $uniqueName;

                if (!move_uploaded_file($_FILES['prod_img']['tmp_name'], $targetPath)) {
                    throw new Exception('Failed to move uploaded file.');
                }

                $prod_img_path = 'uploads/' . $uniqueName;
            }


            if (empty($prod_name) || empty($prod_desc) || $prod_quan <= 0 || $prod_price <= 0 || !$prod_img_path) {
                throw new Exception("All fields are required and image must be uploaded.");
            }

            $created_at = date('Y-m-d H:i:s');
            $prod_code = rand(100000, 999999);

            $result = $productModel->addProduct(
                $prod_code,
                $prod_name,
                $prod_desc,
                $prod_quan,
                $prod_price,
                $prod_img_path,
                $created_at
            );

            echo json_encode([
                'status' => $result ? 'success' : 'error',
                'message' => $result ? 'Product added successfully' : 'Failed to add product'
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
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



}
?>