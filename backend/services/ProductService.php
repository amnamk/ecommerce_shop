<?php
require_once 'BaseService.php';
require_once  __DIR__ .'/../dao/ProductDao.php';

class ProductService extends BaseService {
    
    protected $dao;

    public function __construct() {
        $this->dao = new ProductDao(); 
        parent::__construct($this->dao); 
    }

    public function getByCategory($category): array {
        return $this->dao->getByCategory($category);
    }

    public function updateStockQuantity($id, $quantity) {
        return $this->dao->updateStockQuantity($id, $quantity);
    }

    public function getAllProducts() {
        return $this->dao->getAll();
    }

    public function create($data) {
        return $this->dao->insert($data);
    }

    public function getById($id) {
        return $this->dao->getById($id);
    }

    public function delete($id) {
        $this->dao->delete($id);
    }


}
?>
