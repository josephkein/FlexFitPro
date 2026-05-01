<?php

    session_start();

    if (!isset($_SESSION['role'])) {
        exit('Unauthorized');
    }

    require __DIR__ . '/../../database/database.php';
    require __DIR__ . '/../../controllers/CustomerController.php';
    require __DIR__ . '/../../model/Customer.php';
    $config = require __DIR__ . '/../../config/config.php';

    $db = new Database($config);

    $customer = new Customer($db->getConnection());
    $controller = new CustomerController($customer);

    $type = $_GET['type'] ?? '';
    $membership = $_GET['membership'] ?? '';
    $order = $_GET['order'] ?? '';
    $search = $_GET['search'] ?? '';
    $page = $_GET['page'] ?? 1;

    $p = max(1, $page);

    $limit = 7;
    $off = ($p - 1) * $limit;

    $display = $controller->display($search, $type, strtoupper($order), $membership, $limit, $off);
    
    echo json_encode($display); 

?>