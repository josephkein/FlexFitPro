<?php

    session_start();

    if (!isset($_SESSION['role'])) {
        exit('Unauthorized');
    }

    require __DIR__ . '/../../database/database.php';
    require __DIR__ . '/../../controllers/MembershipController.php';
    require __DIR__ . '/../../model/Membership.php';
    $config = require __DIR__ . '/../../config/config.php';

    $db = new Database($config);

    $membership = new Membership($db->getConnection());
    $controller = new MembershipController($membership);

    $plan = $_GET['plan'] ?? '';
    $status = $_GET['status'] ?? '';
    $search = $_GET['search'] ?? '';
    $page = $_GET['page'] ?? 1;

    $p = max(1, $page);

    $limit = 7;
    $off = ($p - 1) * $limit;

    $display = $controller->display($search, $plan, $limit, $off);
    
    echo json_encode($display); 
?>