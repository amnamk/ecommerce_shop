<?php
require_once 'BaseDao.php';

class SpecialProductDao extends BaseDao {
    public function __construct() {
        parent::__construct('specialproducts');
    }

    public function getAll() {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table . " WHERE specialproduct_id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function insert($specialproduct) {
        $sql = "INSERT INTO " . $this->table . " (product_id, discount, name, description, price, stock_quantity, reviews, picture) 
                VALUES (:product_id, :discount, :name, :description, :price, :stock_quantity, :reviews, :picture)";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([
            ':product_id' => $specialproduct['product_id'],
            ':discount' => $specialproduct['discount'],
            ':name' => $specialproduct['name'],
            ':description' => $specialproduct['description'],
            ':price' => $specialproduct['price'],
            ':stock_quantity' => $specialproduct['stock_quantity'],
            ':reviews' => $specialproduct['reviews'],
            ':picture' => $specialproduct['picture']
        ]);
    }

    public function update($id, $data) {
        $fields = "";
        foreach ($data as $key => $value) {
            $fields .= "$key = :$key, ";
        }
        $fields = rtrim($fields, ", ");
        $sql = "UPDATE " . $this->table . " SET $fields WHERE specialproduct_id = :id";
        $stmt = $this->connection->prepare($sql);
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function delete($id) {
        $stmt = $this->connection->prepare("DELETE FROM " . $this->table . " WHERE specialproduct_id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getByDiscount($discount) {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table . " WHERE discount >= :discount");
        $stmt->bindParam(':discount', $discount);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAvailableProducts() {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table . " WHERE stock_quantity > 0");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function updateStock($id, $quantity) {
        $sql = "UPDATE " . $this->table . " SET stock_quantity = stock_quantity - :quantity WHERE specialproduct_id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function searchByName($name) {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table . " WHERE name LIKE :name");
        $stmt->bindValue(':name', '%' . $name . '%');
        $stmt->execute();
        return $stmt->fetchAll();
    }

}
?>
