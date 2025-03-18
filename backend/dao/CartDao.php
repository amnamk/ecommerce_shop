<?php
require_once 'BaseDao.php';

class CartDao extends BaseDao {
    public function __construct() {
        parent::__construct('cart');
    }

    public function getCartByUserId($user_id) {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table . " WHERE user_id = :user_id");
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($cartItem) {
        $sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([
            ':user_id' => $cartItem['user_id'],
            ':product_id' => $cartItem['product_id'],
            ':quantity' => $cartItem['quantity']
        ]);
    }

    public function getAll() {
        return parent::getAll();
    }

    public function getById($id) {
        return parent::getById($id);
    }

    public function update($id, $data) {
        return parent::update($id, $data);
    }

    public function delete($id) {
        return parent::delete($id);
    }
}
?>
