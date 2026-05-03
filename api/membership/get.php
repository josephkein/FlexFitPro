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

    $id = $_GET['id'] ?? '';

    if (!$id) {
        echo json_encode(['error' => 'ID required']);
        exit;
    }

    // Need to add a get method in Membership model
    $data = $membership->get($id);
    
    echo json_encode($data);
?>