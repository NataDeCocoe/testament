<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Sales.php';

class SalesController extends BaseController{

    private $salesModel;

    public function __construct(){
        $this->salesModel = new Sales();
    }

    public function weeklySales() {
        try {
            $this->salesModel = new Sales();
            $weeklySales = $this->salesModel->getWeeklySales();

            // Initialize an array with all days set to 0
            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            $salesData = array_fill_keys($days, 0);

            // Fill in the actual sales data
            foreach ($weeklySales as $sale) {
                $salesData[$sale['day_name']] = (float)$sale['daily_sales'];
            }

            // Prepare the response
            $response = [
                'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                'sales' => [
                    $salesData['Monday'],
                    $salesData['Tuesday'],
                    $salesData['Wednesday'],
                    $salesData['Thursday'],
                    $salesData['Friday'],
                    $salesData['Saturday'],
                    $salesData['Sunday']
                ]
            ];

            header('Content-Type: application/json');
            echo json_encode($response);

        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function dailySales() {
        // Set JSON header first
        header('Content-Type: application/json');

        try {
            $this->salesModel = new Sales();
            $rawData = $this->salesModel->getDailySales();

            $daysMap = [
                2 => ['label' => 'Mon', 'sales' => 0],
                3 => ['label' => 'Tue', 'sales' => 0],
                4 => ['label' => 'Wed', 'sales' => 0],
                5 => ['label' => 'Thu', 'sales' => 0],
                6 => ['label' => 'Fri', 'sales' => 0],
                7 => ['label' => 'Sat', 'sales' => 0],
                1 => ['label' => 'Sun', 'sales' => 0]
            ];

            foreach ($rawData as $dayData) {
                $dayNum = $dayData['day_of_week'];
                if (isset($daysMap[$dayNum])) {
                    $daysMap[$dayNum]['sales'] = (float)$dayData['daily_sales'];
                }
            }

            $response = [
                'success' => true,
                'data' => [
                    'labels' => array_column($daysMap, 'label'),
                    'sales' => array_column($daysMap, 'sales')
                ]
            ];

            echo json_encode($response);
            exit();

        } catch (PDOException $e) {
            $response = [
                'success' => false,
                'error' => 'Database error',
                'message' => $e->getMessage()
            ];
            http_response_code(500);
            echo json_encode($response);
            exit();
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'error' => 'Application error',
                'message' => $e->getMessage()
            ];
            http_response_code(400);
            echo json_encode($response);
            exit();
        }
    }

}
?>