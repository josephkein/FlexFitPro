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

        $role = $controller->login($username, $password);

        if ($role){
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;

            echo json_encode([
                'status' => 'success',
                'role' => $role
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