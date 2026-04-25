<?php
    require __DIR__ . '/../../database/database.php';
    require __DIR__ . '/../../controllers/CustomerController.php';
    require __DIR__ . '/../../model/Customer.php';
    $config = require __DIR__ . '/../../config/config.php';
    
    $db = new Database($config);

    $customer = new Customer($db->getConnection());
    $controller = new CustomerController($customer);

    $first = trim($_POST['update_first']);
    $last = trim($_POST['update_last']);
    $type = htmlspecialchars($_POST['up_type']);
    $id = $_POST['up_id'];

    $errors = [];

    if (empty($first)) $errors[] = "First name is required";
    if (empty($last)) $errors[] = "Last name is required";
    if (empty($type)) $errors[] = "Customer type is required";

    if (!empty($errors)){
        echo json_encode([
            'status' => 'error',
            'errors' => $errors
        ]);
        exit;
    }

    $username = htmlspecialchars($first . ' ' . $last);
    $controller->update($username, $type, $id);

    echo json_encode([
        'status' => 'success',
        'message' => 'Customer updated successfully'
    ]); 

?>