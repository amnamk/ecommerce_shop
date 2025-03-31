<?php
require_once 'BaseService.php';
require_once 'PaymentDao.php';

class PaymentService extends BaseService {
    

    public function __construct() {
        $this->dao = new PaymentDao(); 
        parent::__construct($this->dao); 
    }


    public function getPaymentsByState($state) {
        return $this->dao->getPaymentsByState($state);
    }

}
?>
