<?php
require_once 'BaseService.php';
require_once  __DIR__ .'/../dao/SpecialProductDao.php';

class SpecialProductService extends BaseService {
  

    public function __construct() {
        $this->dao = new SpecialProductDao(); 
        parent::__construct($this->dao); 
    }

    public function getByDiscount($discount): array {
        return $this->dao->getByDiscount($discount);
    }

    public function getAvailableProducts(): array {
        return $this->dao->getAvailableProducts();
    }

    public function updateStock($id, $quantity) {
        return $this->dao->updateStock($id, $quantity);
    }

    public function searchByName($name): array {
        return $this->dao->searchByName($name);
    }

    public function getById($id) {
        return $this->dao->getById($id);
    }

    public function delete($id) {
        $this->dao->delete($id);
    }

    public function create($data) {
        return $this->dao->insert($data);
    }
}
?>
