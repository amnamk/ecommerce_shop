<?php
require_once '../services/PaymentBusinessLogic.php';

$paymentLogic = new PaymentBusinessLogic();

try {
    
    $invalidPaymentData = [
        'user_id' => 4,
        'cardholder_name' => 'Amna Test',
        'card_number' => '123456789012345', 
        'expiry_date' => '01/28', 
        'cvv' => '122', 
        'address' => 'Invalid Address Lane',
        'state' => 'InvalidState',
        'shipping_fee' => 4.50
    ];

    $result = $paymentLogic->insertPayment($invalidPaymentData);
    echo "Success:";
    print_r($result);
} catch (Exception $e) {
    echo " Error: " . $e->getMessage();
}

?>

