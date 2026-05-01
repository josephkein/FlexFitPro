<?php
    
    $url = $_GET['url'] ?? 'login';

    switch ($url){
        case 'login': 
            require './views/login.php';
            break;
        case 'dashboard':
            require './views/admin_dashboard.php';
            break;
        case 'customers':
            require './views/customers.php';
            break;
        case 'memberships':
            require './views/memberships.php';
            break;
        case 'trainers':
            require './views/trainers.php';
            break;
        case 'assign':
            require './views/trainer_assignment.php';
            break;
        case 'visits':
            require './views/visit_log.php';
            break;
        case 'payments':
            require './views/payments.php';
            break;
        case 'staffs':
            require './views/staff.php';
            break;

    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>FlexFitPro</title>
</head>
<body>

    <script src="./assets/js/sidebar.js"></script>
</body>
</html>

