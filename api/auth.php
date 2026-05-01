<?php
    session_start();

    header('Content-Type: application/json');

    require '../database/database.php';
    require '../controllers/UserController.php';
    require '../model/User.php';
    $config = require '../config/config.php';

    $db = new Database($config);
    $user = new User($db->getConnection());
    $controller = new UserController($user);

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = htmlspecialchars(trim($_POST['user']));
        $password = trim($_POST['pass']);

        if (empty($username) || empty($password)){
            echo json_encode([
                'status' => 'error',
                'message' => 'Username and password is required'
            ]);
            exit;
        }

        $acc = $controller->login($username, $password);

        if ($acc){
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $acc['role'];
            $_SESSION['status'] = $acc['status'];
            $_SESSION['user_id'] = $acc['user_id'];

            if ($acc['status'] != 'active'){
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Your account is not active. Please contact the administrator.'
                ]);
                exit;
            }
 
            echo json_encode([
                'status' => 'success',
                'role' => $acc['role'],
                'act' => $acc['status']
            ]);
        }
        else{
            echo json_encode([
                'status' => 'error',
                'message' => 'Username or password is incorrect'
            ]);
            exit;
        }
    }


?>