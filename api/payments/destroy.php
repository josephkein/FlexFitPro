<?php
    session_start();
    if (!isset($_SESSION['role']) && $_SESSION['role'] != 'admin'){
        die('Unauthorized');
    }

    require __DIR__ . '/../../database/database.php';
    require __DIR__ . '/../../controllers/PaymentController.php';
    require __DIR__ . '/../../model/Payment.php';
    $config = require __DIR__ . '/../../config/config.php';

    $db = new Database($config);

    $payment = new Payment($db->getConnection());
    $controller = new PaymentController($payment);

    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'] ?? '';

    $stat = $controller->delete($id);

    if (!$stat){
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to delete payment'
        ]);
        exit;
    }
    echo json_encode([
        'status' => 'success',
        'message' => 'Payment deleted successfully',
        'id' => $id
    ]);
    exit;
?>