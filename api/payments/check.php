<?php
date_default_timezone_set('Asia/Manila');
session_start();

if (!isset($_SESSION['role'])) {
    exit('Unauthorized');
}

require __DIR__ . '/../../database/database.php';
require __DIR__ . '/../../controllers/MembershipController.php';
require __DIR__ . '/../../model/Membership.php';
require __DIR__ . '/../../controllers/VisitController.php';
require __DIR__ . '/../../model/Visit.php';

$config = require __DIR__ . '/../../config/config.php';
$db = new Database($config);

$membership = new Membership($db->getConnection());
$membershipController = new MembershipController($membership);

$visit = new Visit($db->getConnection());
$visitController = new VisitController($visit);

$customerId = $_POST['logId'] ?? '';
$datetime = date('Y-m-d H:i:s');    
$userId = $_SESSION['user_id'];

if (!$customerId) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Customer ID is required'
    ]);
    exit;
}


/*
|--------------------------------------------------------------------------
| STEP 1 — Check if customer has ACTIVE membership
|--------------------------------------------------------------------------
*/

$activeMembership = $membershipController->getActive($customerId);

if ($activeMembership && $activeMembership['end_date'] >= date('Y-m-d')) {
    $visitController->addVisit($customerId, $userId, $datetime);
    echo json_encode([
        'status' => 'allow',
        'reason' => 'membership_active'

    ]);    
    exit;
}

/*
|--------------------------------------------------------------------------
| STEP 3 — Needs payment for walk-in visit
|--------------------------------------------------------------------------
*/

echo json_encode([
    'status' => 'pay',
    'title' => 'Required payment',
    'message' => 'Customer require to pay',
    'reason' => 'no_active_membership'
]);