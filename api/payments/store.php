<?php
date_default_timezone_set('Asia/Manila');

session_start();

if (!isset($_SESSION['role'])) {
    exit('Unauthorized');
}

require __DIR__ . '/../../database/database.php';
require __DIR__ . '/../../controllers/PaymentController.php';
require __DIR__ . '/../../model/Payment.php';
require __DIR__ . '/../../controllers/MembershipController.php';
require __DIR__ . '/../../model/Membership.php';
require __DIR__ . '/../../controllers/PlanController.php';
require __DIR__ . '/../../model/Plan.php';
require __DIR__ . '/../../controllers/VisitController.php';
require __DIR__ . '/../../model/Visit.php';
require __DIR__ . '/../../controllers/HistoryController.php'; // + history
require __DIR__ . '/../../model/History.php';
$config = require __DIR__ . '/../../config/config.php';

$db = new Database($config);

$payment = new Payment($db->getConnection());
$paymentController = new PaymentController($payment);

$membership = new Membership($db->getConnection());
$membershipController = new MembershipController($membership);

$plan = new Plans($db->getConnection());
$planController = new PlanController($plan);

$visit = new Visit($db->getConnection());
$visitController = new VisitController($visit);

$history = new History($db->getConnection());
$historyController = new HistoryController($history);

$customerId = htmlspecialchars(trim($_POST['customer_id'] ?? ''));
$planId = htmlspecialchars(trim($_POST['plan_id'] ?? ''));
$cash = htmlspecialchars(trim($_POST['cash'] ?? null));
$change = htmlspecialchars(trim($_POST['change'] ?? '0'));
$startDate = htmlspecialchars(trim($_POST['start_date'] ?? date('Y-m-d')));
$today = date('Y-m-d');

$isMembershipPayment = !empty($planId);
$paymentType = $isMembershipPayment ? 'membership' : 'visit';
$amount = null;
$activeMembership = $membershipController->getActive($customerId);


if ($isMembershipPayment) {
    $planData = $planController->get($planId);
    if (!$planData) {
        echo json_encode([
            'status' => 'error',
            'title' => 'Invalid Plan',
            'message' => 'Selected plan is not valid.'
        ]);
        exit;
    }

    $amount = $planData['price'];
} else {
    $amount = htmlspecialchars(trim($_POST['cash'] ?? null));
}

$errors = [];

if (empty($customerId)) $errors[] = "Customer ID is required";
if (empty($paymentType)) $errors[] = "Payment type is required";

if (!is_numeric($amount) || $amount <= 0) {
    $errors[] = "Amount must be a positive number";
}

if ($startDate < $today) {
    $errors[] = "Start date must not be less than current date";
}


if ($isMembershipPayment) {
    if (!is_numeric($cash) || $cash < $amount) {
        $errors[] = "Cash must be numeric and at least the plan amount.";
    }
    if (!is_numeric($change) || $change < 0) {
        $errors[] = "Change must be a valid non-negative number.";
    }
}

if (!empty($errors)) {
    echo json_encode([
        'status' => 'error',
        'errors' => $errors
    ]);
    exit;
}

$datetime = date('Y-m-d H:i:s');
$userId = $_SESSION['user_id'];

$paymentController->create($customerId, $userId, $datetime, $amount, $paymentType);

if ($isMembershipPayment) {

    $planData = $planController->get($planId);
    $newPlanName = $planData['name'];

    if ($activeMembership == null) {

        // FIRST PLAN EVER (old = null)
        $membershipId = $membershipController->create($customerId, $planId, $startDate);

        $historyController->logPlanChange(
            $customerId,
            null,
            $newPlanName,
            $membershipId
        );
    } else {

        // PLAN CHANGE OR RENEWAL
        $oldPlan = $planController->getByMember($activeMembership['id']);
        $oldPlanName = $oldPlan['name'];

        $membershipController->update($activeMembership['id'], $planId, $startDate);

        $historyController->logPlanChange(
            $customerId,
            $oldPlanName,
            $newPlanName,
            $activeMembership['id']
        );
    }
} else {

    $visitId = $visitController->addVisit($customerId, $userId, $datetime);
    $historyController->logVisit($customerId, $datetime, $visitId);
}

echo json_encode([
    'status' => 'success',
    'message' => 'Payment added successfully'
]);
