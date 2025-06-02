<?php
require_once __DIR__ . '/../../config/database.php';

class ShippingCalculator {
    public static function calculate($items, $destinationRegionCode, $db) {
        // Fixed origin: Tagum City is in Region XI
        $originRegion = 'Region XI';

        // Map region codes (from UI) to region names (as stored in jnt_rates)
        $regionCodeMap = [
            '010000000' => 'Region I',
            '020000000' => 'Region II',
            '030000000' => 'Region III',
            '040000000' => 'Region IV-A',
            '170000000' => 'Region IV-B',
            '050000000' => 'Region V',
            '060000000' => 'Region VI',
            '070000000' => 'Region VII',
            '080000000' => 'Region VIII',
            '090000000' => 'Region IX',
            '100000000' => 'Region X',
            '110000000' => 'Region XI',
            '120000000' => 'Region XII',
            '130000000' => 'NCR',
            '140000000' => 'CAR',
            '150000000' => 'BARMM',
            '160000000' => 'Region XIII'
        ];

        if (!isset($regionCodeMap[$destinationRegionCode])) {
            throw new Exception("Unknown region code: $destinationRegionCode");
        }

        $destinationRegion = $regionCodeMap[$destinationRegionCode];

        $stmt = $db->prepare("SELECT base_rate, weight_rate, volumetric_divisor FROM jnt_rates WHERE origin_region = :origin AND destination_region = :destination");
        $stmt->bindParam(':origin', $originRegion);
        $stmt->bindParam(':destination', $destinationRegion);
        $stmt->execute();
        $rateData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$rateData) {
            throw new Exception("Shipping rate not found.");
        }

        $totalWeight = 0;
        $totalVolumetricWeight = 0;

        foreach ($items as $item) {
            $product = self::getProductDetails($item['product_id'], $db);
            if (!$product) continue;

            $quantity = $item['quantity'];
            $weight = $product['weight_kg'] * $quantity;
            $volume = ($product['length_cm'] * $product['width_cm'] * $product['height_cm']) * $quantity;

            $totalWeight += $weight;
            $totalVolumetricWeight += $volume / $rateData['volumetric_divisor'];
        }

        $chargeableWeight = max($totalWeight, $totalVolumetricWeight);
        $shippingFee = $rateData['base_rate'] + ($chargeableWeight * $rateData['weight_rate']);

        return round($shippingFee, 2);
    }

    private static function getProductDetails($productId, $db) {
        $stmt = $db->prepare("SELECT weight_kg, length_cm, width_cm, height_cm FROM products WHERE prod_id = :id");
        $stmt->execute([':id' => $productId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
