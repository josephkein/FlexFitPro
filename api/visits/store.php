<?php
    session_start();

    if (!isset($_SESSION['role'])) {
        exit('Unauthorized');
    }

    require __DIR__ . '/../../database/database.php';
    require __DIR__ . '/../../controllers/VisitController.php';
    require __DIR__ . '/../../model/Visit.php';
    $config = require __DIR__ . '/../../config/config.php';

    $db = new Database($config);

    $visit = new Visit($db->getConnection());
    $controller = new VisitController($visit);

    $id = htmlspecialchars($_POST['logId']);
    $datetime = date('Y-m-d H:i:s');
    $user = $_SESSION['user_id'];

    $controller->addVisit($id, $user, $datetime);
    
    echo json_encode([
        'status' => 'success',
        'message' => 'Visit added successfully'
    ]); 

?>