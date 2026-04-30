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

    $id = $_GET['id'] ?? '';

    $display = $controller->getPayment($id);
    
    echo json_encode($display); 

?>