<?php
require_once 'ProductBusinessLogic.php';

class ProductController {
    private $productBusinessLogic;

    public function __construct() {
        $this->productBusinessLogic = new ProductBusinessLogic();
    }

    public function handleRequest() {
        // Handle GET request
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (isset($_GET['category'])) {
                // Search by category
                try {
                    $category = $_GET['category'];
                    $products = $this->productBusinessLogic->getByCategory($category);
                    echo json_encode(['message' => 'Products fetched by category', 'data' => $products]);
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
            } elseif (isset($_GET['id'])) {
                // Fetch product by ID
                try {
                    $id = $_GET['id'];
                    $product = $this->productBusinessLogic->getById($id);

                    if (!$product) {
                        throw new Exception('Product not found.');
                    }

                    echo json_encode(['message' => 'Product fetched by ID', 'data' => $product]);
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
            } elseif (isset($_GET['all'])) {
                
                try {
                    $products = $this->productBusinessLogic->getAllProducts();

                    if (empty($products)) {
                        throw new Exception('No products available.');
                    }

                    echo json_encode(['message' => 'All products fetched successfully', 'data' => $products]);
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
            } else {
                echo json_encode(['error' => 'Category, Product ID, or all parameter is required for search.']);
            }
        }

        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $data = $_POST;

            
            if (empty($data['name']) || empty($data['description']) || empty($data['price']) || empty($data['category']) || empty($data['stock_quantity']) || empty($data['picture'])) {
                echo json_encode(['error' => 'All fields (name, description, price, category, stock quantity, picture) are required.']);
                return;
            }

            try {
                
                $result = $this->productBusinessLogic->insert($data);
                echo json_encode(['message' => 'Product created successfully.', 'data' => $result]);
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
        }
    }
}
?>
