<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    die('Unauthorized');
}
require __DIR__ . '/../../database/database.php';
require __DIR__ . '/../../controllers/VisitController.php';
require __DIR__ . '/../../model/Visit.php';

$config = require __DIR__ . '/../../config/config.php';
$db = new Database($config);

$id = $_POST['id'] ?? null;

$visit = new Visit($db->getConnection());
$visitController = new VisitController($visit);

if (empty($id)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Visit ID is required',
    ]);
    exit;
}

$deleted = $visitController->destroy($id);

if (!$deleted) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to delete visit',
    ]);
    exit;
}

echo json_encode([
    'status' => 'success',
    'message' => 'Visit deleted successfully',
]);
