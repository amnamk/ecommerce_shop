<?php
require_once 'SpecialProductBusinessLogic.php';

class SpecialProductController {

    private $specialProductBusinessLogic;

    public function __construct() {
        $this->specialProductBusinessLogic = new SpecialProductBusinessLogic();
    }

    public function handleRequest() {

        
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

            if (isset($_GET['discount'])) {
                try {
                    $discount = $_GET['discount'];
                    $products = $this->specialProductBusinessLogic->getByDiscount($discount);
                    echo json_encode(['message' => 'Products fetched by discount', 'data' => $products]);
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
            } elseif (isset($_GET['name'])) {
                
                try {
                    $name = $_GET['name'];
                    $products = $this->specialProductBusinessLogic->searchByName($name);
                    echo json_encode(['message' => 'Products found by name', 'data' => $products]);
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
            } else {
                
                try {
                    $products = $this->specialProductBusinessLogic->getAvailableProducts();
                    echo json_encode(['message' => 'Available products fetched', 'data' => $products]);
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
            }
        }

        
    }

    public function createProduct() {
     
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
           
            $data = $_POST;
    
            
            if (empty($data['name']) || empty($data['description']) || empty($data['price']) || empty($data['category']) || empty($data['stock_quantity']) || empty($data['picture']) || empty($data['discount'])) {
               
                echo json_encode(['error' => 'All fields (name, description, price, category, stock quantity, picture) are required.']);
                return;
            }
    
            try {
               
                $result = $this->specialProductBusinessLogic->create($data);
    
                
                echo json_encode(['message' => 'Product created successfully.', 'data' => $result]);
    
            } catch (Exception $e) {
               
                echo json_encode(['error' => $e->getMessage()]);
            }
        } else {
            
            echo json_encode(['error' => 'Only POST requests are allowed.']);
        }
    }
}
?>
