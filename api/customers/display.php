<?php
    require __DIR__ . '/../../database/database.php';
    require __DIR__ . '/../../controllers/CustomerController.php';
    require __DIR__ . '/../../model/Customer.php';
    $config = require __DIR__ . '/../../config/config.php';

    $db = new Database($config);

    $customer = new Customer($db->getConnection());
    $controller = new CustomerController($customer);

    $type = $_GET['type'] ?? '';
    $member = $_GET['member'] ?? '';
    $search = $_GET['search'] ?? '';

    $display = $controller->display($search, $type, $member);
    
    echo json_encode($display); 

?>