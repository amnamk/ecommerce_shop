<?php
require_once 'ProductService.php';

class ProductBusinessLogic {

    private $productService;

    public function __construct() {
        $this->productService = new ProductService();
    }

    public function getByCategory($category) {
        if (empty($category)) {
            throw new Exception('Category cannot be empty.');
        }

        $category = trim($category);
        $products = $this->productService->getByCategory($category);

        if (empty($products)) {
            throw new Exception('No products found for the provided category.');
        }

        return $products;
    }

    public function updateStockQuantity($id, $quantity) {
        if ($id <= 0) {
            throw new Exception('Invalid product ID.');
        }

        if ($quantity < 0) {
            throw new Exception('Stock quantity cannot be negative.');
        }

        $updated = $this->productService->updateStockQuantity($id, $quantity);

        if (!$updated) {
            throw new Exception('Failed to update stock quantity.');
        }

        return true;
    }
}
?>
