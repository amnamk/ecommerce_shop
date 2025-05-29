<?php
require_once 'BaseDao.php';

class CartDao extends BaseDao {
    public function __construct() {
        parent::__construct('cart', 'cart_id'); 
    }

    public function getCartByUserId($user_id) {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM {$this->table} WHERE user_id = :user_id");
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if ($result) {
                return $result; 
            } else {
                throw new Exception("No cart items found for user_id: $user_id.");
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    public function getCartRegularProducts($userId) {
        $stmt = $this->connection->prepare("
            SELECT 
                c.cart_id,
                c.user_id,
                c.quantity,
                p.product_id,
                p.name,
                p.description,
                p.price,
                p.stock_quantity,
                p.reviews,
                p.category,
                p.picture
            FROM cart c
            INNER JOIN products p ON c.product_id = p.product_id
            WHERE c.user_id = :user_id
        ");
        
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCartSpecialProducts($userId) {
        $stmt = $this->connection->prepare("
            SELECT 
                c.cart_id,
                c.user_id,
                c.quantity,
                sp.specialproduct_id,
                sp.name,
                sp.description,
                (sp.price - (sp.price * sp.discount / 100)) AS discounted_price,
                sp.stock_quantity,
                sp.reviews,
                sp.picture
            FROM cart c
            INNER JOIN specialproducts sp ON c.specialproduct_id = sp.specialproduct_id
            WHERE c.user_id = :user_id
        ");
        
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getAllCartProducts($userId) {
        $stmt = $this->connection->prepare("
            SELECT 
                c.cart_id,
                p.product_id, 
                p.name, 
                p.description, 
                p.price, 
                p.stock_quantity, 
                p.reviews,  
                p.picture, 
                'regular' AS type
            FROM cart c
            INNER JOIN products p ON c.product_id = p.product_id
            WHERE c.user_id = :user_id
            
            UNION ALL
            
            SELECT 
                c.cart_id,
                sp.specialproduct_id AS product_id, 
                sp.name, 
                sp.description, 
                (sp.price - (sp.price * sp.discount / 100))  AS price,
                sp.stock_quantity, 
                sp.reviews, 
                sp.picture, 
                'specialproduct' AS type
            FROM cart c
            INNER JOIN specialproducts sp ON c.specialproduct_id = sp.specialproduct_id
            WHERE c.user_id = :user_id
        ");
        
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateCartItemQuantity($cartItemId, $quantity) {
        $query = "UPDATE cart SET quantity = :quantity WHERE cart_id = :id";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $statement->bindParam(':id', $cartItemId, PDO::PARAM_INT);
        $statement->execute();

        return $statement->rowCount(); 
    }
    
}
?>
