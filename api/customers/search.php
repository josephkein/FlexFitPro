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

    $query = trim($_GET['q'] ?? '');
    if (strlen($query) < 2) {
        echo json_encode([]);
        exit;
    }

    $search = htmlspecialchars($query) . '%';
    $suggestions = $controller->suggestion($search);

    echo json_encode($suggestions);
