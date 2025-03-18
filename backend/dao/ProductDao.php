<?php
require_once 'BaseDao.php';

class ProductDao extends BaseDao {
    public function __construct() {
        parent::__construct('products'); 
    }

    
    public function getAll() {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    
    public function getById($id) {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table . " WHERE product_id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

  
    public function insert($product) {
        $sql = "INSERT INTO " . $this->table . " (name, description, price, stock_quantity, reviews, category,  picture) 
                VALUES (:name, :description, :price, :stock_quantity, :reviews, :category, :picture)";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([
            ':name' => $product['name'],
            ':description' => $product['description'],
            ':price' => $product['price'],
            ':stock_quantity' => $product['stock_quantity'],
            ':reviews' => $product['reviews'],
            ':category' => $product['category'],
            ':picture' => $product['picture']
        ]);
    }

    public function update($id, $data) {
        $fields = "";
        foreach ($data as $key => $value) {
            $fields .= "$key = :$key, ";
        }
        $fields = rtrim($fields, ", ");
        $sql = "UPDATE " . $this->table . " SET $fields WHERE product_id = :id";
        $stmt = $this->connection->prepare($sql);
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function delete($id) {
        $stmt = $this->connection->prepare("DELETE FROM " . $this->table . " WHERE product_id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    
}
?>
