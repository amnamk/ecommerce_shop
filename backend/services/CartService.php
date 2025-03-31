<?php
require_once 'BaseService.php';
require_once 'CartDao.php';

class CartService extends BaseService {
    
    public function __construct() {
        $this->dao = new CartDao();
        parent::__construct($this->dao);
    }

    public function getCartByUserId($user_id): array {
        return $this->dao->getCartByUserId($user_id);
    }

    public function getCartRegularProducts($userId): array {
        return $this->dao->getCartRegularProducts($userId);
    }

    public function getCartSpecialProducts($userId): array {
        return $this->dao->getCartSpecialProducts($userId);
    }

    public function getCartItems($userId): array {
        $regularProducts = $this->dao->getCartRegularProducts($userId);
        $specialProducts = $this->dao->getCartSpecialProducts($userId);
        
        return array_merge($regularProducts, $specialProducts);
    }
}
?>
