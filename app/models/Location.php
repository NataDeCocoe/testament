<?php
require_once __DIR__ . '/../../config/database.php';

class Location{


    private $db;

    public function __construct(){
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function fetchRegions() {
        $stmt = $this->db->prepare("SELECT code, description FROM region");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchProvinces($regionCode) {
        $stmt = $this->db->prepare("SELECT code, description FROM province WHERE region_id = ?");
        $stmt->execute([$regionCode]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchMunicipalities($provinceCode) {
        $stmt = $this->db->prepare("SELECT muncity_id, description FROM muncity WHERE province_id = ?");
        $stmt->execute([$provinceCode]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchBarangays($citymunCode) {
        $stmt = $this->db->prepare("SELECT code, description FROM barangay WHERE muncity_id = ?");
        $stmt->execute([$citymunCode]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}
?>