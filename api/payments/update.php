<?php
    session_start();

    if (!isset($_SESSION['role'])) {
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
        exit;
    }

    require __DIR__ . '/../../database/database.php';
    require __DIR__ . '/../../controllers/PaymentController.php';
    require __DIR__ . '/../../model/Payment.php';
    $config = require __DIR__ . '/../../config/config.php';

    $db = new Database($config);

    $payment = new Payment($db->getConnection());
    $controller = new PaymentController($payment);

    $payment_id = $_POST['payment_id'] ?? '';
    $amount = $_POST['amount'] ?? '';
    $payment_type = $_POST['payment_type'] ?? '';

    if (empty($payment_id) || empty($amount) || empty($payment_type)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
        exit;
    }

    if ($amount <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Amount must be greater than 0']);
        exit;
    }

    $result = $controller->update($payment_id, $amount, $payment_type);

    if ($result) {
        echo json_encode(['status' => 'success', 'message' => 'Payment updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update payment']);
    }
?>