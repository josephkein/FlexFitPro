<?php
    session_start();
    if (!isset($_SESSION['role']) && $_SESSION['role'] != 'admin'){
        die('Unauthorized');
    }

    require __DIR__ . '/../../database/database.php';
    require __DIR__ . '/../../controllers/TrainerController.php';
    require __DIR__ . '/../../model/Trainer.php';
    $config = require __DIR__ . '/../../config/config.php';

    $db = new Database($config);

    $trainer = new Trainer($db->getConnection());
    $controller = new TrainerController($trainer);

    $id = $_POST['id'] ?? '';

    if (empty($id)){
        echo json_encode([
            'status' => 'fail'
        ]);
        exit;
    }

    $display = $controller->destroy($id);
    $status = '';

    if ($display){
        $status = 'success';
    }
    else{
        $status = 'fail';
    }

    echo json_encode([
        'status' => $status
    ]); 

?>