<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Categories.php';


class CategoriesController extends BaseController{

    private $categoriesModel;


    public function __construct(){
        $this->categoriesModel = new Categories();
    }

    public function getCategories() {
        header('Content-Type: application/json');
        echo json_encode($this->categoriesModel->getAllCategories());
        return $this->categoriesModel->getAllCategories();
    }
}
?>