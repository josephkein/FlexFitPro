<?php
    session_start();
    if (!isset($_SESSION['role'])) {
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
        exit;
    }

    require __DIR__ . '/../../database/database.php';
    require __DIR__ . '/../../model/Assign.php';
    require __DIR__ . '/../../controllers/AssignController.php';
    $config = require __DIR__ . '/../../config/config.php';

    $db = new Database($config);
    $assign = new Assign($db->getConnection());
    $controller = new AssignController($assign);

    $assign_id = $_POST['assign_id'] ?? '';
    $customer_id = $_POST['customer_id'] ?? '';
    $trainer_id = $_POST['trainer_id'] ?? '';
    $start_date = $_POST['start_date'] ?? '';
    $end_date = $_POST['end_date'] ?? '';

    if (empty($assign_id) || empty($customer_id) || empty($trainer_id) || empty($start_date) || empty($end_date)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
        exit;
    }

    if ($start_date < date('Y-m-d')){
        echo json_encode(['status' => 'error', 'message' => 'Start date cannot be before current date']);
        exit;
    }

    if (strtotime($end_date) < strtotime($start_date)) {
        echo json_encode(['status' => 'error', 'message' => 'End date cannot be before start date']);
        exit;
    }

    $data = $controller->update($customer_id, $trainer_id, $start_date, $end_date, $assign_id);

    if ($data) {
        echo json_encode(['status' => 'success', 'message' => 'Assignment updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update assignment']);
    }
?>