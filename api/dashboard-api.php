<?php
    require '../database/database.php';
    require '../controllers/PaymentController.php';
    require '../model/Payment.php';
    require '../controllers/VisitController.php';
    require '../model/Visit.php';
    $config = require '../config/config.php';

    $db = new Database($config);

    $pay = new Payment($db->getConnection());
    $visit = new Visit($db->getConnection());

    $payController = new PaymentController($pay);
    $visitController = new VisitController($visit);
    
    // $month = json_decode(file_get_contents("php://input"), true);

    $data = $payController->totalRevenue();
    $daily = $payController->dailyRevenue();
    $monthly = $visitController->monthlyVisit();
    $total_visit = $visitController->totalVisit();
    $monthlyReven = $payController->getMonthly();
    $daily_visit = $visitController->dailyVisits();
    

    echo json_encode([
        'total' => $data,
        'monthly_revenue' => $monthlyReven,
        'year' => date('Y'),
        'monthly_visit' => $monthly,
        'daily' => $daily,
        'total_visit' => $total_visit,
        'daily_visit' => $daily_visit
    ]);

?>