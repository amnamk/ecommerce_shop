<?php
require_once 'BaseDao.php';

class PaymentDao extends BaseDao {
    public function __construct() {
        parent::__construct('payments', 'payment_id'); 
    }

    

    public function getPaymentsByState($state) {
        $stmt = $this->connection->prepare("SELECT * FROM payments WHERE state = :state");
        $stmt->bindParam(':state', $state);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }




   

    
}
?>
