<?php
require_once 'BaseService.php';
require_once  __DIR__ .'/../dao/FavoritesDao.php';

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
    public function delete($id) {
        return $this->dao->delete($id);
    }

    public function create($data) {
        return $this->dao->insert($data);
    }
}
