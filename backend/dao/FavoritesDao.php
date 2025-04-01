<?php
require_once 'BaseDao.php';

class FavoritesDao extends BaseDao {
    public function __construct() {
        parent::__construct('favorites', 'favorite_id'); 
    }

    public function getByUserId($userId) {
        $stmt = $this->connection->prepare("SELECT * FROM {$this->table} WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByProductId($productId) {
        $stmt = $this->connection->prepare("SELECT * FROM {$this->table} WHERE product_id = :product_id");
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFavoriteProducts($userId) {
        $stmt = $this->connection->prepare("
            SELECT p.product_id, p.name, p.description, p.price, p.stock_quantity, p.reviews, p.category, p.picture
            FROM favorites f
            INNER JOIN products p ON f.product_id = p.product_id
            WHERE f.user_id = :user_id
        ");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getFavoriteSpecialProducts($userId) {
        $stmt = $this->connection->prepare("
            SELECT sp.specialproduct_id, sp.discount, sp.name, sp.description, sp.price, sp.stock_quantity, sp.reviews, sp.picture
            FROM favorites f
            INNER JOIN specialproducts sp ON f.specialproduct_id = sp.specialproduct_id
            WHERE f.user_id = :user_id
        ");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllFavoriteProducts($userId) {
        $stmt = $this->connection->prepare("
            SELECT 
                p.product_id, p.name, p.description, p.price, p.stock_quantity, p.reviews, p.picture, 'product' AS type
            FROM favorites f
            INNER JOIN products p ON f.product_id = p.product_id
            WHERE f.user_id = :user_id
            
            UNION ALL
            
            SELECT 
                sp.specialproduct_id AS product_id, 
                sp.name, 
                sp.description, 
                sp.price, 
                sp.stock_quantity, 
                sp.reviews, 
                
                sp.picture, 
                'specialproduct' AS type
            FROM favorites f
            INNER JOIN specialproducts sp ON f.specialproduct_id = sp.specialproduct_id
            WHERE f.user_id = :user_id
        ");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    
    
    
}
?>
