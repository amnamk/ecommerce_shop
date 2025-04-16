<?php
require_once 'SpecialProductService.php';

class SpecialProductBusinessLogic {

    private $specialProductService;

    public function __construct() {
        $this->specialProductService = new SpecialProductService();
    }

    public function getByDiscount($discount) {
        if ($discount < 0 || $discount > 100) {
            throw new Exception('Discount must be between 0 and 100.');
        }

        $products = $this->specialProductService->getByDiscount($discount);

        if (empty($products)) {
            throw new Exception('No products found with the given discount.');
        }

        return $products;
    }

    public function getAvailableProducts(): array {
        $products = $this->specialProductService->getAvailableProducts();

        if (empty($products)) {
            throw new Exception('No available products found.');
        }

        return $products;
    }

    public function updateStock($id, $quantity): bool {
        if ($id <= 0) {
            throw new Exception('Invalid product ID.');
        }

        if ($quantity < 0) {
            throw new Exception('Quantity cannot be negative.');
        }

        $updated = $this->specialProductService->updateStock($id, $quantity);

        if (!$updated) {
            throw new Exception('Failed to update stock.');
        }

        return true;
    }

    public function searchByName($name): array {
        if (empty($name)) {
            throw new Exception('Product name cannot be empty.');
        }

        $name = trim($name);
        $products = $this->specialProductService->searchByName($name);

        if (empty($products)) {
            throw new Exception('No products found with the given name.');
        }

        return $products;
    }

    public function delete($id) {
        if (empty($id)) {
            throw new Exception('Id can not be empty.');
        }
        return $this->specialProductService->delete($id);
    }
    public function create($data) {
        
        if (empty($data['name'])) {
            throw new Exception('Product name cannot be empty.');
        }
        if (strlen($data['name']) > 100) {
            throw new Exception('Product name cannot exceed 100 characters.');
        }

        if (empty($data['description'])) {
            throw new Exception('Product description cannot be empty.');
        }

        if (!isset($data['price']) || !is_numeric($data['price']) || $data['price'] <= 0) {
            throw new Exception('Product price must be a positive numeric value.');
        }

        if (!isset($data['stock_quantity']) || !is_numeric($data['stock_quantity']) || $data['stock_quantity'] < 0) {
            throw new Exception('Product stock quantity must be a non-negative integer.');
        }

        if (!empty($data['reviews']) && strlen($data['reviews']) > 100) {
            throw new Exception('Product reviews cannot exceed 100 characters.');
        }

        if (!empty($data['picture']) && strlen($data['picture']) > 200) {
            throw new Exception('Product picture URL cannot exceed 200 characters.');
        }

        if (!isset($data['discount']) || !is_numeric($data['discount']) || $data['discount'] < 0 || $data['discount'] > 100) {
            throw new Exception('Discount must be a numeric value between 0 and 100.');
        }

        
        $productData = [
            'name' => trim($data['name']),
            'description' => trim($data['description']),
            'price' => (float)$data['price'],
            'stock_quantity' => (int)$data['stock_quantity'],
            'reviews' => isset($data['reviews']) ? trim($data['reviews']) : null,
            'picture' => isset($data['picture']) ? trim($data['picture']) : null,
            'discount' => (float)$data['discount']
        ];

                try {
            return $this->specialProductService->create($productData);
        } catch (Exception $e) {
            throw new Exception('Failed to create the product: ' . $e->getMessage());
        }
    }
}
?>
