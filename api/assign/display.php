<?php
    session_start();

    if (!isset($_SESSION['role'])) {
        exit('Unauthorized');
    }

    require __DIR__ . '/../../database/database.php';
    require __DIR__ . '/../../controllers/AssignController.php';
    require __DIR__ . '/../../model/Assign.php';
    $config = require __DIR__ . '/../../config/config.php';

    $db = new Database($config);

    $assign = new Assign($db->getConnection());
    $controller = new AssignController($assign);

    $search = $_GET['search'] ?? '';
    $page = $_GET['page'] ?? 1;
    $end = $_GET['end'] ?? '';
    $session = $_GET['session'] ?? '';

    $limit = 7;
    $off = ($page - 1) * $limit;

    $data = $controller->display($search, $end, $session, $limit, $off);

    echo json_encode($data);
?>