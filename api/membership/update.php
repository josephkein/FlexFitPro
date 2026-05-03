<?php
session_start();

if (!isset($_SESSION['role'])) {
    exit('Unauthorized');
}

require __DIR__ . '/../../database/database.php';
require __DIR__ . '/../../controllers/MembershipController.php';
require __DIR__ . '/../../model/Membership.php';
$config = require __DIR__ . '/../../config/config.php';

$db = new Database($config);

$membership = new Membership($db->getConnection());
$controller = new MembershipController($membership);

$membershipId = intval($_POST['membership_id'] ?? 0);
$planId = intval($_POST['plan_id'] ?? 0);
$startDate = trim($_POST['start_date'] ?? '');

$errors = [];

if (!$membershipId) {
    $errors[] = 'Membership ID is required';
}
if (!$planId) {
    $errors[] = 'Plan ID is required';
}
if (empty($startDate)) {
    $errors[] = 'Start date is required';
}

if (!empty($errors)) {
    echo json_encode([
        'status' => 'error',
        'message' => implode(' ', $errors),
        'errors' => $errors,
    ]);
    exit;
}

$updated = $controller->update($membershipId, $planId, $startDate);

if ($updated) {
    echo json_encode([
        'status' => 'success',
        'message' => 'Membership updated successfully',
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Unable to update membership',
    ]);
}
