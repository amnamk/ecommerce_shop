<?php
require_once 'BaseService.php';
require_once 'ProductDao.php';

class ProductService extends BaseService {
    
    protected $dao;

    public function __construct() {
        $this->dao = new ProductDao(); 
        parent::__construct($this->dao); 
    }

    public function getByCategory($category) {
        return $this->dao->getByCategory($category);
    }

    public function updateStockQuantity($id, $quantity) {
        return $this->dao->updateStockQuantity($id, $quantity);
    }
}
?>
