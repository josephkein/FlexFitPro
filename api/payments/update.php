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
    require __DIR__ . '/../../controllers/VisitController.php';
    require __DIR__ . '/../../model/Visit.php';
    $config = require __DIR__ . '/../../config/config.php';

    $db = new Database($config);

    $payment = new Payment($db->getConnection());
    $controller = new PaymentController($payment);


    $customerId = htmlspecialchars(trim($_POST['customer_id'] ?? ''));
    $type = 'visit';
    $amount = htmlspecialchars(trim($_POST['cash'] ?? null));

    $membership = new Membership($db->getConnection());
    $membershipController = new MembershipController($membership);

    $visit = new Visit($db->getConnection());
    $visitController = new VisitController($visit);

    $activeMembership = $membershipController->getActive($customerId);


    if (!$activeMembership && $amount == null) {
        echo json_encode([
            'status' => 'payment_required',
            'title' => 'Failed to Log Visit',
            'message' => 'Customer must pay before logging visit'
        ]);
        exit;
    }

    if ($amount <= 0){
        echo json_encode([
            'status' => 'error',
            'title' => 'Invalid Amount',
            'message' => 'Amount must be a positive number'
        ]);
        exit;
    }

    $errors = [];

    if (empty($customerId)) $errors[] = "Customer ID is required";
    if (empty($type)) $errors[] = "Payment type is required";

    if (empty($amount) || !is_numeric($amount) || $amount <= 0){
        $errors[] = "Amount must be positive number";
    }
    if (!empty($errors)){
        echo json_encode([
            'status' => 'error',
            'errors' => $errors
        ]);
        exit;
    }

    $datetime = date('Y-m-d H:i:s');    
    $userId = $_SESSION['user_id'];

    $controller->create($customerId, $userId, $datetime, $amount, $type);
    $visitController->addVisit($customerId, $userId, $datetime);
    
    echo json_encode([
        'status' => 'success',
        'message' => 'Payment added successfully'
    ]); 

?>