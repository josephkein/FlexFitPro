<?php
date_default_timezone_set('Asia/Manila');
session_start();

if (!isset($_SESSION['role'])) {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

require __DIR__ . '/../../database/database.php';
$config = require __DIR__ . '/../../config/config.php';

$db = (new Database($config))->getConnection();

$customerId = intval($_GET['id'] ?? 0);
if (!$customerId) {
    echo json_encode(['error' => 'Invalid customer ID']);
    exit;
}

function safe($v) {
    return ($v === null || $v === '' || $v === '0000-00-00 00:00:00') ? null : $v;
}

//
// ── 1. PREVIOUS PLAN (OFFSET 1) ─────────────────────────────
//
$stmt = $db->prepare("
    SELECT old_value, new_value, changed_at
    FROM customer_history
    WHERE customer_id = ?
      AND change_type = 'plan'
    ORDER BY changed_at DESC
    LIMIT 1 OFFSET 1
");

$stmt->bind_param('i', $customerId);
$stmt->execute();
$plan = $stmt->get_result()->fetch_assoc();
$stmt->close();


// fallback if no previous
if (!$plan) {
    $stmt = $db->prepare("
        SELECT old_value, new_value, changed_at
        FROM customer_history
        WHERE customer_id = ?
          AND change_type = 'plan'
        ORDER BY changed_at DESC
        LIMIT 1
    ");
    $stmt->bind_param('i', $customerId);
    $stmt->execute();
    $plan = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

//
// ── 2. PREVIOUS TRAINER (OFFSET 1) ──────────────────────────
//
$stmt = $db->prepare("
    SELECT old_value, new_value, changed_at
    FROM customer_history
    WHERE customer_id = ?
      AND change_type = 'trainer'
    ORDER BY changed_at DESC
    LIMIT 1 OFFSET 1
");

$stmt->bind_param('i', $customerId);
$stmt->execute();
$trainer = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$trainer) {
    $stmt = $db->prepare("
        SELECT old_value, new_value, changed_at
        FROM customer_history
        WHERE customer_id = ?
          AND change_type = 'trainer'
        ORDER BY changed_at DESC
        LIMIT 1
    ");
    $stmt->bind_param('i', $customerId);
    $stmt->execute();
    $trainer = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

//
// ── 3. PREVIOUS VISIT (OFFSET 1) ────────────────────────────
//
$stmt = $db->prepare("
    SELECT new_value AS visit_date, changed_at
    FROM customer_history
    WHERE customer_id = ?
      AND change_type = 'visit'
    ORDER BY changed_at DESC
    LIMIT 1 OFFSET 1
");

$stmt->bind_param('i', $customerId);
$stmt->execute();
$visit = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$visit) {
    $stmt = $db->prepare("
        SELECT new_value AS visit_date, changed_at
        FROM customer_history
        WHERE customer_id = ?
          AND change_type = 'visit'
        ORDER BY changed_at DESC
        LIMIT 1
    ");
    $stmt->bind_param('i', $customerId);
    $stmt->execute();
    $visit = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

echo json_encode([
    'plan'    => $plan ? array_map('safe', $plan) : null,
    'trainer' => $trainer ? array_map('safe', $trainer) : null,
    'visit'   => $visit ? array_map('safe', $visit) : null
]);
?>