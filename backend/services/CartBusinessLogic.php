<?php
require_once 'CartService.php';

class CartBusinessLogic {
    private $cartService;

    public function __construct() {
        $this->cartService = new CartService();
    }

    public function getCartItems($userId) {
        if (empty($userId)) {
            throw new Exception('User ID is required.');
        }

        return $this->cartService->getCartItems($userId);
    }

    public function addToCart($data) {
        if ($data['quantity'] <= 0) {
            throw new Exception('Quantity must be a positive number.');
        }

        if (!isset($data['product_id']) && !isset($data['specialproduct_id'])) {
            throw new Exception('Either product_id or specialproduct_id must be provided.');
        }

        $cartItems = $this->cartService->getCartItems($data['user_id']);
        
        foreach ($cartItems as $item) {
            if (isset($data['product_id']) && $item['product_id'] == $data['product_id'] && $item['type'] == 'regular') {
                throw new Exception('Product is already in the cart.');
            }
            if (isset($data['specialproduct_id']) && $item['product_id'] == $data['specialproduct_id'] && $item['type'] == 'specialproduct') {
                throw new Exception('Special product is already in the cart.');
            }
        }

        return $this->cartService->create($data);
    }

    public function updateCartQuantity($cartId, $quantity) {
        if ($quantity <= 0) {
            throw new Exception('Quantity must be a positive number.');
        }

        return $this->cartService->update($cartId, ['quantity' => $quantity]);
    }

    public function delete($id) {
        return $this->cartService->delete($id); 
    }
}
