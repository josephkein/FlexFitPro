<?php

    session_start();

    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        exit('Unauthorized');
    }

    require __DIR__ . '/../../database/database.php';
    require __DIR__ . '/../../controllers/StaffController.php';
    require __DIR__ . '/../../model/Staff.php';
    $config = require __DIR__ . '/../../config/config.php';

    $db = new Database($config);

    $staff = new Staff($db->getConnection());
    $controller = new StaffController($staff);

    $username = $_POST['username'] ?? '';
    $role = $_POST['role'] ?? '';
    $status = $_POST['status'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($username) || empty($role) || empty($status) || empty($password) || empty($confirm_password)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Missing required fields'
        ]);
        exit;
    }

    if ($password !== $confirm_password){
        echo json_encode([
            'status' => 'error',
            'message' => 'Password and confirm password do not match'
        ]);
        exit;
    }

    $stat = $controller->store($username, $role, $status, $password, $confirm_password);
    if (!$stat){
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to create staff account'
        ]);
        exit;
    }

    echo json_encode([
        'status' => 'success',
        'message' => 'Staff account created successfully'
    ]);

?>