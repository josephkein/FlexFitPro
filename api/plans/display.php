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

    $data = $controller->display();

    echo json_encode($data);

?>