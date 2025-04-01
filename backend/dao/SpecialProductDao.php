<?php
require_once 'BaseDao.php';

class SpecialProductDao extends BaseDao {
    public function __construct() {
        parent::__construct('specialproducts', 'specialproduct_id'); 
    }

    
    public function getByDiscount($discount) {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table . " WHERE discount >= :discount");
        $stmt->bindParam(':discount', $discount);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function getAvailableProducts() {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table . " WHERE stock_quantity > 0");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function updateStock($id, $quantity) {
        
        $sql = "SELECT stock_quantity FROM " . $this->table . " WHERE specialproduct_id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $currentStock = $stmt->fetchColumn();
    
        if ($currentStock >= $quantity) {
            
            $sql = "UPDATE " . $this->table . " SET stock_quantity = stock_quantity - :quantity WHERE specialproduct_id = :id";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } else {
            
            return false;
        }
    }
    

    
    public function searchByName($name) {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table . " WHERE name LIKE :name");
        $stmt->bindValue(':name', '%' . $name . '%');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>
