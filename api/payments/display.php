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

    $type = $_GET['type'] ?? '';
    $date = $_GET['date'] ?? '';
    $search = $_GET['search'] ?? '';
    $page = $_GET['page'] ?? 1;

    $p = max(1, $page);

    $limit = 7;
    $off = ($p - 1) * $limit;

    $display = $controller->display($search, $type, $date, $limit, $off);
    
    echo json_encode($display); 

?>