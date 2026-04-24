<?php
    require __DIR__ . '/../../database/database.php';
    require __DIR__ . '/../../controllers/TrainerController.php';
    require __DIR__ . '/../../model/Trainer.php';
    $config = require __DIR__ . '/../../config/config.php';

    $db = new Database($config);

    $trainer = new Trainer($db->getConnection());
    $controller = new TrainerController($trainer);

    $first = htmlspecialchars(trim($_POST['first_name']));
    $last = htmlspecialchars(trim($_POST['last_name']));
    $rate = htmlspecialchars(trim($_POST['rate']));
    $capacity = htmlspecialchars(trim($_POST['capacity']));

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

    $name = htmlspecialchars($first . ' ' . $last);
    $controller->addTrainer($first, $last, $rate, $capacity);
    
    echo json_encode([
        'status' => 'success',
        'message' => 'Trainer added successfully'
    ]); 

?>