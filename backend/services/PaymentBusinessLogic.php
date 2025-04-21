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

    public function getAllPayments(){
        return $this->paymentService->getAll();
    }

    public function insertPayment($data) {
        if (empty($data['user_id']) || empty($data['cardholder_name']) || empty($data['card_number']) ||
            empty($data['expiry_date']) || empty($data['cvv']) || empty($data['address']) || empty($data['state']) || empty($data['shipping_fee'])) {
            throw new Exception('All fields are required.');
        }
    
        $user_id = (int)$data['user_id'];
        $cardholder_name = htmlspecialchars(trim($data['cardholder_name']));
        $card_number = htmlspecialchars(trim($data['card_number']));
        $expiry_date = htmlspecialchars(trim($data['expiry_date']));
        $cvv = htmlspecialchars(trim($data['cvv']));
        $address = htmlspecialchars(trim($data['address']));
        $state = htmlspecialchars(trim($data['state']));
        $shipping_fee = (float)$data['shipping_fee'];
    
        
        if (!preg_match('/^\d{3}$/', $cvv)) {
            throw new Exception('CVV must be exactly 3 digits.');
        }
    
        
        if (!preg_match('/^(0[1-9]|1[0-2])\/\d{2}$/', $expiry_date)) {
            throw new Exception('Expiry date must be in MM/YY format.');
        }
        
        
        list($expMonth, $expYear) = explode('/', $expiry_date);
        $expYear = '20' . $expYear; 
        $expiryDateObj = DateTime::createFromFormat('Y-m-d', "$expYear-$expMonth-01");
        $expiryDateObj->modify('last day of this month');
        
        $now = new DateTime();
        
        if ($expiryDateObj < $now) {
            throw new Exception('Expiry date must be a future date.');
        }
    
        
        if (!preg_match('/^\d{13,19}$/', $card_number)) {
            throw new Exception('Card number must be between 13 and 19 digits.');
        }
    
        $paymentData = [
            'user_id' => $user_id,
            'cardholder_name' => $cardholder_name,
            'card_number' => $card_number,
            'expiry_date' => $expiry_date,
            'cvv' => $cvv,
            'address' => $address,
            'state' => $state,
            'shipping_fee' => $shipping_fee
        ];
    
        try {
            $result = $this->paymentService->create($paymentData);
            if ($result) {
                return ['message' => 'Payment successfully inserted.', 'data' => $paymentData];
            } else {
                throw new Exception('Failed to insert payment.');
            }
        } catch (Exception $e) {
            throw new Exception('Error while inserting payment: ' . $e->getMessage());
        }
    }
    
}
?>