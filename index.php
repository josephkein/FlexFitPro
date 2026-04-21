<?php
    
    $url = $_GET['url'] ?? 'login';

    switch ($url){
        case 'login': 
            require './views/login.php';
            break;
        case 'admin':
            require './views/admin_dashboard.php';
            break;
        case 'customers':
            require './views/customers.php';
            break;
        case 'memberships':
            require './views/memberships.php';
            break;
        case 'visits':
            require './views/visit_log.php';
            break;
        case 'trainers':
            require './views/trainers.php';
            break;
        case 'assign':
            require './views/trainer_assignment.php';
            break;
        case 'visits':
            require './views/visits.php';
            break;
        case 'payments':
            require './views/payments.php';
            break;
        case 'staffs':
            require './views/staff.php';
            break;

    }

?>

