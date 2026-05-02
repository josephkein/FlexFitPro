<?php

    session_start();

    if (!isset($_SESSION['role'])) {
        exit('Unauthorized');
    }

    require __DIR__ . '/../../database/database.php';
    require __DIR__ . '/../../controllers/TrainerController.php';
    require __DIR__ . '/../../model/Trainer.php';
    $config = require __DIR__ . '/../../config/config.php';

    $db = new Database($config);

    $trainer = new Trainer($db->getConnection());
    $controller = new TrainerController($trainer);

    
    $search = $_GET['search'] ?? '';
    $min = $_GET['min'] ?? '';
    $max = $_GET['max'] ?? '';
    $page = $_GET['page'] ?? 1;

    $p = max(1, $page);

    $limit = 7;
    $off = ($p - 1) * $limit;

    $display = $controller->display($search, $min, $max, $limit, $off);
    
    echo json_encode($display); 

?>