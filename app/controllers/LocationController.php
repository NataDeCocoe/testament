<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Location.php';

class LocationController extends BaseController{

    private $locationModel;

    public function __construct(){
        $this->locationModel = new Location();
    }
    public function getRegions() {
        $this->locationModel = new Location();
        echo json_encode($this->locationModel->fetchRegions());
    }

    public function getProvinces() {
        $regionCode = $_GET['region_code'] ?? '';
        $regionCode = substr($regionCode, 0, 2); // Keep only "01"
        $data = $this->locationModel->fetchProvinces($regionCode);
        echo json_encode($data);
    }

    public function getMunicipalities() {
        $provinceCode = $_GET['province_code'] ?? '';
        $provinceCode = substr($provinceCode, 0, 2);
        $data = $this->locationModel->fetchMunicipalities($provinceCode);
        echo json_encode($data);
    }

    public function getBarangays() {
        $muncityId = isset($_GET['muncity_id']) ? (int) $_GET['muncity_id'] : 0;
        $barangays = $this->locationModel->fetchBarangays($muncityId);
        echo json_encode($barangays);
    }

}
?>