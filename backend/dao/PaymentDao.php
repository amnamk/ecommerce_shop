<?php
require_once 'BaseDao.php';

class PaymentDao extends BaseDao {
    public function __construct() {
        parent::__construct('payments');
    }

    public function getPaymentById($paymentId) {
        $stmt = $this->connection->prepare("SELECT * FROM payments WHERE payment_id = :payment_id");
        $stmt->bindParam(':payment_id', $paymentId);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getAllPaymentsByUserId($userId) {
        $stmt = $this->connection->prepare("SELECT * FROM payments WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getPaymentsByState($state) {
        $stmt = $this->connection->prepare("SELECT * FROM payments WHERE state = :state");
        $stmt->bindParam(':state', $state);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function updatePaymentCardInfo($paymentId, $cardholderName, $cardNumber, $expiryDate, $cvv) {
        $sql = "UPDATE payments SET cardholder_name = :cardholder_name, card_number = :card_number, expiry_date = :expiry_date, cvv = :cvv WHERE payment_id = :payment_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':cardholder_name', $cardholderName);
        $stmt->bindParam(':card_number', $cardNumber);
        $stmt->bindParam(':expiry_date', $expiryDate);
        $stmt->bindParam(':cvv', $cvv);
        $stmt->bindParam(':payment_id', $paymentId);
        return $stmt->execute();
    }

    public function updatePaymentAddress($paymentId, $address, $state, $shippingFee) {
        $sql = "UPDATE payments SET address = :address, state = :state, shipping_fee = :shipping_fee WHERE payment_id = :payment_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':state', $state);
        $stmt->bindParam(':shipping_fee', $shippingFee);
        $stmt->bindParam(':payment_id', $paymentId);
        return $stmt->execute();
    }

    public function deletePaymentsByState($state) {
        $stmt = $this->connection->prepare("DELETE FROM payments WHERE state = :state");
        $stmt->bindParam(':state', $state);
        return $stmt->execute();
    }

    public function insert($payment) {
        $sql = "INSERT INTO payments (user_id, amount, cardholder_name, card_number, expiry_date, cvv, address, state, shipping_fee, created_at) 
                VALUES (:user_id, :amount, :cardholder_name, :card_number, :expiry_date, :cvv, :address, :state, :shipping_fee, :created_at)";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([
            ':user_id' => $payment['user_id'],
            ':amount' => $payment['amount'],
            ':cardholder_name' => $payment['cardholder_name'],
            ':card_number' => $payment['card_number'],
            ':expiry_date' => $payment['expiry_date'],
            ':cvv' => $payment['cvv'],
            ':address' => $payment['address'],
            ':state' => $payment['state'],
            ':shipping_fee' => $payment['shipping_fee'],
            ':created_at' => $payment['created_at']
        ]);
    }
}
?>
