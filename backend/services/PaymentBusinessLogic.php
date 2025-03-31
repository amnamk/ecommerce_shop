<?php
require_once 'PaymentService.php';

class PaymentBusinessLogic {
    private $paymentService;

    public function __construct() {
        $this->paymentService = new PaymentService(); 
    }

    public function getPaymentsByState($state) {
        
        if (empty($state)) {
            throw new Exception('State cannot be empty.');
        }

        
        $state = trim($state);

        
        $payments = $this->paymentService->getPaymentsByState($state);

        
        if (empty($payments)) {
            throw new Exception('No payments found for the provided state.');
        }

        
        return $payments;
    }
}
?>