<?php
    
    session_start();

    if (!isset($_SESSION['role'])) {
        exit('Unauthorized');
    }

    require '../database/database.php';
    require '../controllers/PaymentController.php';
    require '../model/Payment.php';
    $config = require '../config/config.php';

    $db = new Database($config);

    $payment = new Payment($db->getConnection());
    $controller = new PaymentController($payment);

    $data = $controller->recent();

    echo json_encode($data);



?>