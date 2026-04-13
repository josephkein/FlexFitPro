<?php
    
    $url = $_GET['url'] ?? 'login';

    switch ($url){
        case 'login': 
            require './views/login.php';
            break;
        case 'admin':
            require './views/admin_dashboard.php';
            break;
    }

?>
