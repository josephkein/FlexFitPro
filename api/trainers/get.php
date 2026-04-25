<?php
    require __DIR__ . '/../../database/database.php';
    require __DIR__ . '/../../controllers/TrainerController.php';
    require __DIR__ . '/../../model/Trainer.php';
    $config = require __DIR__ . '/../../config/config.php';

    $db = new Database($config);

    $trainer = new Trainer($db->getConnection());
    $controller = new TrainerController($trainer);

    $id = $_GET['id'] ?? '';

    $display = $controller->getTrainer($id);
    
    echo json_encode($display); 

?>