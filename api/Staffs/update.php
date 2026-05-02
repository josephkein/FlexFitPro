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

    $username = $_POST['update_username'] ?? '';
    $role = $_POST['update_role'] ?? '';
    $status = $_POST['update_status'] ?? '';
    $password = $_POST['update_password'] ?? '';
    $user_id = $_POST['acc_id'] ?? '';

    // Validate required fields
    if (empty($user_id) || empty($username) || empty($role) || empty($status)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Missing required fields'
        ]);
        exit;
    }

    $stat = $controller->update($user_id, $username, $role, $status, $password);

    if ($stat) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Staff account updated successfully'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to update staff account'
        ]);
    }

?>