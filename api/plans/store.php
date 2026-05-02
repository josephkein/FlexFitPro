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

    $plan = $_POST['plan_name'] ?? '';
    $duration = $_POST['duration'] ?? '';
    $price = $_POST['price'] ?? '';

    if (empty($plan) || empty($duration) || empty($price)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Missing required fields'
        ]);
        exit;
    }

    $data = $controller->create($plan, $duration, $price);

    if (!$data){
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to create plan'
        ]);
        exit;
    }

    echo json_encode([
        'status' => 'success',
        'message' => 'Plan created successfully'
    ]);
    exit;

?>