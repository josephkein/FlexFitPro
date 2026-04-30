<?php
    session_start();

    if (!isset($_SESSION['role'])) {
        exit('Unauthorized');
    }

    require __DIR__ . '/../../database/database.php';
    require __DIR__ . '/../../controllers/PaymentController.php';
    require __DIR__ . '/../../model/Payment.php';
    $config = require __DIR__ . '/../../config/config.php';

    $db = new Database($config);

    $payment = new Payment($db->getConnection());
    $controller = new PaymentController($payment);

    $customerId = htmlspecialchars(trim($_POST['customer_id'] ?? ''));
    $type = htmlspecialchars(trim($_POST['payment_type'] ?? ''));
    $amount = htmlspecialchars(trim($_POST['amount'] ?? ''));

    $errors = [];

    if (empty($customerId)) $errors[] = "Customer ID is required";
    if (empty($type)) $errors[] = "Payment type is required";

    if (empty($amount) || !is_numeric($amount) || $amount <= 0){
        $errors[] = "Amount must be positive number";
    }

    if (empty($capacity) || !filter_var($capacity, FILTER_VALIDATE_INT) || $capacity <= 0){
        $errors[] = "Rate must be positive number";
    }


    if (!empty($errors)){
        echo json_encode([
            'status' => 'error',
            'errors' => $errors
        ]);
        exit;
    }

    
    echo json_encode([
        'status' => 'success',
        'message' => 'Trainer added successfully'
    ]); 

?>