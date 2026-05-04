<?php
    require '../database/database.php';
    require '../controllers/PaymentController.php';
    require '../model/Payment.php';
    require '../controllers/VisitController.php';
    require '../model/Visit.php';
    require '../controllers/TrainerController.php';
    require '../model/Trainer.php';
    require '../controllers/MembershipController.php';
    require '../model/Membership.php';
    $config = require '../config/config.php';

    $db = new Database($config);

    $pay = new Payment($db->getConnection());
    $visit = new Visit($db->getConnection());
    $trainer = new Trainer($db->getConnection());
    $member = new Membership($db->getConnection());

    $payController = new PaymentController($pay);
    $visitController = new VisitController($visit);
    $trainerController = new TrainerController($trainer);
    $memberController = new MembershipController($member);
    
    // $month = json_decode(file_get_contents("php://input"), true);

    $data = $payController->totalRevenue();
    $daily = $payController->dailyRevenue();
    $monthly = $visitController->monthlyVisit();
    $total_visit = $visitController->totalVisit();
    $monthlyReven = $payController->getMonthly();
    $daily_visit = $visitController->dailyVisits();
    $available_trainer = $trainerController->available();
    $today = $visitController->todayVisit();
    

    echo json_encode([
        'total' => $data,
        'monthly_revenue' => $monthlyReven,
        'year' => date('Y'),
        'monthly_visit' => $monthly,
        'daily' => $daily,
        'total_visit' => $total_visit,
        'daily_visit' => $daily_visit,
        'available' => $available_trainer,
        'today' => $today
    ]);

?>