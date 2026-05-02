<?php
    session_start();
    header('Content-Type: application/json');

    if (!isset($_SESSION['role'])) {
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
        exit;
    }

    require __DIR__ . '/../../database/database.php';
    require __DIR__ . '/../../controllers/VisitController.php';
    require __DIR__ . '/../../model/Visit.php';

    $config = require __DIR__ . '/../../config/config.php';
    $db = new Database($config);

    $customer_id = $_POST['customer_id'] ?? null;
    $cash = $_POST['cash'] ?? 0;
    $user_id = $_SESSION['user_id'];
    $datetime = date('Y-m-d H:i:s');


    $visit = new Visit($db->getConnection());
    $visitController = new VisitController($visit);

    $visitController->addVisit($customer_id, $user_id, $datetime);

    echo json_encode([
        'status' => 'success',
        'message' => 'Visit logged successfully'
    ]);
?>