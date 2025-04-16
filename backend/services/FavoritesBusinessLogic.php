<?php
require_once 'FavoritesService.php';

class FavoritesBusinessLogic {
    private $favoritesService;

    public function __construct() {
        $this->favoritesService = new FavoritesService();
    }

    public function getFavoritesByUserId($userId): array {
        if (empty($userId)) {
            throw new Exception('User ID is required.');
        }

        return $this->favoritesService->getByUserId($userId);
    }

    public function getFavoriteByProductId($productId): array {
        if (empty($productId)) {
            throw new Exception('Product ID is required.');
        }

        return $this->favoritesService->getByProductId($productId);
    }

    public function getFavoriteProducts($userId): array {
        if (empty($userId)) {
            throw new Exception('User ID is required.');
        }

        return $this->favoritesService->getFavoriteProducts($userId);
    }

    public function getFavoriteSpecialProducts($userId): array {
        if (empty($userId)) {
            throw new Exception('User ID is required.');
        }

        return $this->favoritesService->getFavoriteSpecialProducts($userId);
    }

    public function delete($id) {
        if (empty($id)) {
            throw new Exception('Favorite ID is required.');
        }

        return $this->favoritesService->delete($id);
    }

   
    public function insert($data) {
        if (empty($data['user_id']) || (!isset($data['product_id']) && !isset($data['specialproduct_id']))) {
            throw new Exception('User ID and either Product ID or Special Product ID are required.');
        }

        return $this->favoritesService->create($data);
    }

    public function getAllFavorites($userId) {
        if (empty($userId)) {
            throw new Exception('User ID is required.');
        }

        return $this->favoritesService->getAllFavoriteProducts($userId);
    }
}
?>
