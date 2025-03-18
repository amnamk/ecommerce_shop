<?php
require_once 'BaseDao.php';

class FavoritesDao extends BaseDao {
    public function __construct() {
        parent::__construct('favorites'); 
    }

    
    public function getAll() {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table);
        $stmt->execute();
        return $stmt->fetchAll();
    }

   
    public function getById($id) {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table . " WHERE favorite_id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

 
    public function insert($favorite) {
        $sql = "INSERT INTO " . $this->table . " (user_id, specialproduct_id, product_id) 
                VALUES (:user_id, :specialproduct_id, :product_id)";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([
            ':user_id' => $favorite['user_id'],
            ':specialproduct_id' => $favorite['specialproduct_id'],
            ':product_id' => $favorite['product_id']
        ]);
    }

    
    public function update($id, $data) {
        $fields = "";
        foreach ($data as $key => $value) {
            $fields .= "$key = :$key, ";
        }
        $fields = rtrim($fields, ", ");
        $sql = "UPDATE " . $this->table . " SET $fields WHERE favorite_id = :id";
        $stmt = $this->connection->prepare($sql);
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    
    public function delete($id) {
        $stmt = $this->connection->prepare("DELETE FROM " . $this->table . " WHERE favorite_id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

   
    public function getByUserId($userId) {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table . " WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll();
    }

   
    public function getByProductId($productId) {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table . " WHERE product_id = :product_id");
        $stmt->bindParam(':product_id', $productId);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>
