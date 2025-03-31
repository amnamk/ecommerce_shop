<?php
require_once 'BaseService.php';
require_once 'FavoritesDao.php';

class FavoritesService extends BaseService {
    public function __construct() {
        $this->dao = new FavoritesDao();  
        parent::__construct($this->dao);  
    }

    public function getByUserId($userId) {
        return $this->dao->getByUserId($userId);
    }

    public function getByProductId($productId) {
        return $this->dao->getByProductId($productId);
    }

    public function getFavoriteProducts($userId) {
        return $this->dao->getFavoriteProducts($userId);
    }

    public function getFavoriteSpecialProducts($userId) {
        return $this->dao->getFavoriteSpecialProducts($userId);
    }

    public function getAllFavoriteProducts($userId) {
        return $this->dao->getAllFavoriteProducts($userId);
    }
}
