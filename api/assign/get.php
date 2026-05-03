<?php
    session_start();
    if (!isset($_SESSION['role'])) {
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
        exit;
    }

    require __DIR__ . '/../../database/database.php';
    require __DIR__ . '/../../model/Assign.php';
    require __DIR__ . '/../../controllers/AssignController.php';
    $config = require __DIR__ . '/../../config/config.php';

    $db = new Database($config);
    $assign = new Assign($db->getConnection());
    $controller = new AssignController($assign);

    $id = $_GET['id'] ?? '';

    if (empty($id)) {
        echo json_encode(['status' => 'error', 'message' => 'ID is required']);
        exit;
    }

    $result = $controller->get($id);
    
    if ($result) {
        echo json_encode($result);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Assignment not found']);
    }
?>