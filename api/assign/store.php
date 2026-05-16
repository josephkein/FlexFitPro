<?php
session_start();
if (!isset($_SESSION['role'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

require __DIR__ . '/../../database/database.php';
require __DIR__ . '/../../model/Assign.php';
require __DIR__ . '/../../controllers/AssignController.php';
require __DIR__ . '/../../controllers/HistoryController.php';
require __DIR__ . '/../../model/History.php';

$config = require __DIR__ . '/../../config/config.php';

$db = new Database($config);
$assign = new Assign($db->getConnection());
$controller = new AssignController($assign);

$history = new History($db->getConnection());
$historyController = new HistoryController($history);

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

//
// ─────────────────────────────────────────────
// IF CUSTOMER HAS PREVIOUS ASSIGNMENT
// ─────────────────────────────────────────────
//
if ($get != null){

    // SAME TRAINER AND STILL ACTIVE
    if ($get['customer_id'] == $customer_id && $get['trainer_id'] == $trainer_id && $get['end'] >= date('Y-m-d')){
        echo json_encode(['status' => 'error', 'message' => 'Trainer assignment already exist.']);
        exit;
    }

    // UPDATE ASSIGNMENT (trainer change or expired)
    $oldTrainer = $get['trainer'];

    $updated = $controller->update($customer_id, $trainer_id, $start_date, $end_date, $get['id']);

    if ($updated) {

        // 🔥 INSERT HISTORY (never update)
        $trainer = $controller->search($customer_id);
        $historyController->logTrainerChange(
            $customer_id,
            $oldTrainer,
            $trainer['trainer'],
            $get['id']
        );

        echo json_encode(['status' => 'success', 'message' => 'Assignment updated successfully']);
        exit;
    }

    echo json_encode(['status' => 'error', 'message' => 'Failed to update assignment']);
    exit;
}

//
// ─────────────────────────────────────────────
// FIRST ASSIGNMENT EVER
// ─────────────────────────────────────────────
//
$assignId = $controller->create($customer_id, $trainer_id, $start_date, $end_date);

if ($assignId) {

    // first trainer → old is NULL
    $trainer = $controller->search($customer_id);
    $historyController->logTrainerChange(
        $customer_id,
        null,
        $trainer['trainer'],
        $assignId
    );

    echo json_encode(['status' => 'success', 'message' => 'Assignment created successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to create assignment']);
}
?>