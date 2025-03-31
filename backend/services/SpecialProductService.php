<?php
require_once 'BaseService.php';
require_once 'SpecialProductDao.php';

class SpecialProductService extends BaseService {
  

    public function __construct() {
        $this->dao = new SpecialProductDao(); 
        parent::__construct($this->dao); 
    }

    public function getByDiscount($discount) {
        return $this->dao->getByDiscount($discount);
    }

    public function getAvailableProducts() {
        return $this->dao->getAvailableProducts();
    }

    public function updateStock($id, $quantity) {
        return $this->dao->updateStock($id, $quantity);
    }

    public function searchByName($name) {
        return $this->dao->searchByName($name);
    }
}
?>
