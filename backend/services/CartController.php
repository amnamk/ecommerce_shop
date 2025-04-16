<?php
require_once 'CartBusinessLogic.php';

class CartController {
    private $cartBusinessLogic;

    public function __construct() {
        $this->cartBusinessLogic = new CartBusinessLogic();
    }

    public function handleRequest() {
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            
            if (empty($data['user_id']) || (empty($data['product_id']) && empty($data['specialproduct_id'])) || empty($data['quantity'])) {
                echo json_encode(['error' => 'User ID, Product ID or Special Product ID, and Quantity are required.']);
                return;
            }

            try {
                $result = $this->cartBusinessLogic->addToCart($data);
                echo json_encode(['message' => 'Product added to cart successfully.', 'data' => $result]);
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
        }

        
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            
            if (isset($_GET['user_id'])) {
                try {
                    $userId = $_GET['user_id'];
                    $cartItems = $this->cartBusinessLogic->getCartItems($userId);
                    echo json_encode($cartItems);
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
            } else {
                echo json_encode(['error' => 'User ID is required.']);
            }
        }
    }
}
?>
