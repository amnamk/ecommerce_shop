<?php
require_once 'BaseService.php';
require_once  __DIR__ .'/../dao/PaymentDao.php';

class PaymentService extends BaseService {
    

    public function __construct() {
        $this->dao = new PaymentDao(); 
        parent::__construct($this->dao); 
    }


    public function getPaymentsByState($state) {
        return $this->dao->getPaymentsByState($state);
    }

    public function getAllPayments(){
        return $this->getAll();
    }

    public function delete($id) {
        $this->dao->delete($id);
    }

    public function create($data) {
        return $this->dao->insert($data);
    }

}
?>
