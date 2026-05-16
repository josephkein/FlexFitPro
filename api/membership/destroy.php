<?php
    session_start();

    if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
        exit('Unauthorized');
    }

    require __DIR__ . '/../../database/database.php';
    require __DIR__ . '/../../controllers/MembershipController.php';
    require __DIR__ . '/../../model/Membership.php';
    $config = require __DIR__ . '/../../config/config.php';

    $db = new Database($config);

    $membership = new Membership($db->getConnection());
    $controller = new MembershipController($membership);

    $id = json_decode(file_get_contents('php://input'), true)['id'] ?? '';

    if (!$id) {
        echo json_encode(['status' => 'error', 'message' => 'ID required']);
        exit;
    }

    $controller->delete($id);
    
    echo json_encode(['status' => 'success']);
?>