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

    $customer_id = $_POST['customer_id'] ?? '';
    $trainer_id = $_POST['trainer_id'] ?? '';
    $start_date = $_POST['start_date'] ?? '';
    $end_date = $_POST['end_date'] ?? '';

    if (empty($customer_id) || empty($trainer_id) || empty($start_date) || empty($end_date)) {
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
    

    $get = $controller->search($customer_id);   
    $cap = $controller->isFull($trainer_id);

    if ($cap['capacity'] == $cap['current']){
        echo json_encode(['status' => 'error', 'message' => 'Trainer capacity is already full']);
        exit;
    }

    if ($get != null){

        if ($get['customer_id'] == $customer_id && $get['trainer_id'] == $trainer_id && $get['end'] < date('Y-m-d')){
            $data = $controller->update($customer_id, $trainer_id, $start_date, $end_date, $get['id']);
        }

        if ($get['customer_id'] == $customer_id && $get['trainer_id'] == $trainer_id){
            echo json_encode(['status' => 'error', 'message' => 'Trainer assignment already exist.']);
            exit;
        }

        if ($get['end'] < date('Y-m-d')){
            $data = $controller->update($customer_id, $trainer_id, $start_date, $end_date, $get['id']);
            if ($data) {
                echo json_encode(['status' => 'success', 'message' => 'Assignment created successfully']);
                exit;
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to create assignment']);
                exit;
            }
        }
        else{
            echo json_encode(['status' => 'error', 'message' => 'Assignment still ongoing']);
            exit;
        }
    }
    else{

        $q = $controller->create($customer_id, $trainer_id, $start_date, $end_date);

        if ($q) {
            echo json_encode(['status' => 'success', 'message' => 'Assignment created successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to create assignment']);
        }
    }
?>