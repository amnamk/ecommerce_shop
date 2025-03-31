<?php
require_once 'BaseDao.php';

class ProductDao extends BaseDao {
    public function __construct() {
        parent::__construct('products', 'product_id'); 
    }

    
    public function getByCategory($category) {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table . " WHERE category = :category");
        $stmt->bindParam(':category', $category);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStockQuantity($id, $quantity) {
        $sql = "UPDATE " . $this->table . " SET stock_quantity = :stock_quantity WHERE product_id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':stock_quantity', $quantity);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    
}
?>
