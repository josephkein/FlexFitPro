<?php


    session_start();

    if (!isset($_SESSION['role'])) {
        exit('Unauthorized');
    }

    require __DIR__ . '/../../database/database.php';
    require __DIR__ . '/../../controllers/PlanController.php';
    require __DIR__ . '/../../model/Plan.php';
    $config = require __DIR__ . '/../../config/config.php';

    $db = new Database($config);

    $plan = new Plans($db->getConnection());
    $controller = new PlanController($plan);

    $plan = $_POST['update_plan'] ?? '';
    $duration = $_POST['update_duration'] ?? '';
    $price = $_POST['update_price'] ?? '';
    $id = $_POST['planId'] ?? '';

    if (empty($plan) || empty($duration) || empty($price) || empty($id)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Missing required fields'
        ]);
        exit;
    }

    $data = $controller->update($id, $plan, $duration, $price);

    if (!$data){
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to update plan'
        ]);
        exit;
    }

    echo json_encode([
        'status' => 'success',
        'message' => 'Plan updated successfully'
    ]);
    exit;

?>