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

        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $data = $_POST;

            if (empty($data['cart_id']) || empty($data['quantity'])) {
                echo json_encode(['error' => 'Cart ID and Quantity are required.']);
                return;
            }

            try {
                
                $result = $this->cartBusinessLogic->updateCartQuantity($data['cart_id'], $data['quantity']);
                echo json_encode(['message' => 'Cart quantity updated successfully.', 'data' => $result]);
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $data = $_POST;

            if (empty($data['id'])) {
                echo json_encode(['error' => 'Cart item ID is required for deletion.']);
                return;
            }

            try {
                
                $result = $this->cartBusinessLogic->delete($data['id']);
                echo json_encode(['message' => 'Cart item deleted successfully.']);
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
        }
    }
}
?>
