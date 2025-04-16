<?php
require_once 'PaymentBusinessLogic.php';

class PaymentController {
    private $paymentBusinessLogic;

    public function __construct() {
        $this->paymentBusinessLogic = new PaymentBusinessLogic();
    }

    public function handleRequest() {
        
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (isset($_GET['state'])) {
                
                try {
                    $state = $_GET['state'];
                    $payments = $this->paymentBusinessLogic->getPaymentsByState($state);
                    echo json_encode(['message' => 'Payments found for the provided state', 'data' => $payments]);
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
            } elseif (isset($_GET['all'])) {
                
                try {
                    $payments = $this->paymentBusinessLogic->getAllPayments();
                    echo json_encode(['message' => 'All payments retrieved successfully', 'data' => $payments]);
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }}
        }

        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $data = $_POST;

            
            if (empty($data['user_id']) || empty($data['cardholder_name']) || empty($data['card_number']) ||
                empty($data['expiry_date']) || empty($data['cvv']) || empty($data['address']) || empty($data['state']) || empty($data['shipping_fee'])) {
                echo json_encode(['error' => 'All fields are required to create a payment entry.']);
                return;
            }

            
            try {
                $result = $this->paymentBusinessLogic->insertPayment($data);
                echo json_encode($result);
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
        }
    }
}
?>
