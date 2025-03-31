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

    public function getAvailableProducts() {
        $products = $this->specialProductService->getAvailableProducts();

        if (empty($products)) {
            throw new Exception('No available products found.');
        }

        return $products;
    }

    public function updateStock($id, $quantity) {
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

    public function searchByName($name) {
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
}
?>
