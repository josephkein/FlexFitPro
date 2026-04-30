<?php

    session_start();

    if (!isset($_SESSION['role'])) {
        exit('Unauthorized');
    }

    require __DIR__ . '/../../database/database.php';
    require __DIR__ . '/../../controllers/StaffController.php';
    require __DIR__ . '/../../model/Staff.php';
    $config = require __DIR__ . '/../../config/config.php';

    $db = new Database($config);

    $staff = new Staff($db->getConnection());
    $controller = new StaffController($staff);

    $role = $_GET['role'] ?? '';
    $status = $_GET['status'] ?? '';
    $search = $_GET['search'] ?? '';
    $page = $_GET['page'] ?? 1;

    $p = max(1, $page);

    $limit = 7;
    $off = ($p - 1) * $limit;

    $display = $controller->display($search, $role, $status, $limit, $off);
    
    echo json_encode($display); 

?>