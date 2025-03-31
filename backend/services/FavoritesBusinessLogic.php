<?php
require_once 'FavoritesService.php';

class FavoritesBusinessLogic {
    private $favoritesService;

    public function __construct() {
        $this->favoritesService = new FavoritesService();
    }

    public function getFavoritesByUserId($userId) {
        if (empty($userId)) {
            throw new Exception('User ID cannot be empty.');
        }

        $favorites = $this->favoritesService->getByUserId($userId);

        if (empty($favorites)) {
            throw new Exception('No favorites found for the provided user ID.');
        }

        return $favorites;
    }

    public function getFavoriteByProductId($productId) {
        if (empty($productId)) {
            throw new Exception('Product ID cannot be empty.');
        }

        $favoriteProduct = $this->favoritesService->getByProductId($productId);

        if (empty($favoriteProduct)) {
            throw new Exception('No favorite found for the provided product ID.');
        }

        return $favoriteProduct;
    }

    public function getFavoriteProducts($userId) {
        if (empty($userId)) {
            throw new Exception('User ID cannot be empty.');
        }

        $favoriteProducts = $this->favoritesService->getFavoriteProducts($userId);

        if (empty($favoriteProducts)) {
            throw new Exception('No favorite products found for the provided user ID.');
        }

        return $favoriteProducts;
    }

    public function getFavoriteSpecialProducts($userId) {
        if (empty($userId)) {
            throw new Exception('User ID cannot be empty.');
        }

        $favoriteSpecialProducts = $this->favoritesService->getFavoriteSpecialProducts($userId);

        if (empty($favoriteSpecialProducts)) {
            throw new Exception('No favorite special products found for the provided user ID.');
        }

        return $favoriteSpecialProducts;
    }

    public function delete($id) {
        return $this->favoritesService->delete($id); 
    }

    public function getAll($id) {
        return $this->favoritesService->delete($id); 
    }

    public function insert($data) {
        return $this->favoritesService->create($data);
    }

    public function getAllFavorites($userId) {
        if (empty($userId)) {
            throw new Exception('User ID cannot be empty.');
        }

        $userId = trim($userId);

        $favorites = $this->favoritesService->getAllFavoriteProducts($userId);

        if (empty($favorites)) {
            throw new Exception('No favorite products or special products found for the given user.');
        }

        return $favorites;
    }
}
?>
