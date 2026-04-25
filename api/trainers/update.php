<?php
    
    require __DIR__ . '/../../database/database.php';
    require __DIR__ . '/../../controllers/TrainerController.php';
    require __DIR__ . '/../../model/Trainer.php';
    $config = require __DIR__ . '/../../config/config.php';

    $db = new Database($config);

    $trainer = new Trainer($db->getConnection());
    $controller = new TrainerController($trainer);

    $first = htmlspecialchars(trim($_POST['up_first'] ?? ''));
    $last = htmlspecialchars(trim($_POST['up_last'] ?? ''));
    $rate = htmlspecialchars(trim($_POST['up_rate'] ?? ''));
    $capacity = htmlspecialchars(trim($_POST['up_cap'] ?? ''));
    $id = $_POST['up_tid'] ?? '';

    $errors = [];
    if (empty($first)) $errors[] = "First name is required";
    if (empty($last)) $errors[] = "Last name is required";

    if (empty($rate) || !is_numeric($rate) || $rate <= 0){
        $errors[] = "Rate must be positive number";
    }

    if (empty($capacity) || !filter_var($capacity, FILTER_VALIDATE_INT) || $capacity <= 0){
        $errors[] = "Rate must be positive number";
    }


    if (!empty($errors)){
        echo json_encode([
            'status' => 'error',
            'errors' => $errors
        ]);
        exit;
    }
    
    $controller->update($first, $last, $rate, $capacity, $id);
    
    echo json_encode([
        'status' => 'success',
        'message' => 'Trainer updated successfully'
    ]); 

?>