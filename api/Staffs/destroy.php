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

    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data['id'] ?? '';

    $stat = $controller->delete($id);

    if (!$stat){
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to delete staff account',
            'id' => $id
        ]);
        exit;
    }
    echo json_encode([
        'status' => 'success',
        'message' => 'Staff account deleted successfully'
    ]);

?>