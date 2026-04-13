<?php
    session_start();
    require '../database/database.php';
    require '../controllers/UserController.php';
    require '../model/User.php';
    $config = require '../config/config.php';

    $db = new Database($config);
    $user = new User($db->getConnection());
    $controller = new UserController($user);

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = trim($_POST['user']);
        $password = trim($_POST['pass']);

        unset($_SESSION['invalid']);
        unset($_SESSION['empty_user']);
        unset($_SESSION['empty_pass']);
        unset($_SESSION['role']);
        unset($_SESSION['user']);
        unset($_SESSION['pass']);

        if (!empty($username) && !empty($password)){
            $role = $controller->login($username, $password);
            $_SESSION['role'] = $role;
            if ($role == 'admin'){
                header('Location: ../index.php?url=admin');
                exit;
            }
            else if($role == 'staff'){
                header('Location: ../index.php?url=staff');
                exit;
            }
            else{
                $_SESSION['user'] = $username;
                $_SESSION['pass'] = $password;
                $_SESSION['invalid'] = "Incorrect username or password.";
                header('Location: ../index.php?url=login');
                exit;
            }
        }
        else{
            $_SESSION['user'] = $username;
            $_SESSION['pass'] = $password;
            if (empty($username)) $_SESSION['empty_user'] = 'Username is required.';
            if (empty($password)) $_SESSION['empty_pass'] = 'Password is required.';
            header('Location: ../index.php?url=login');
            exit;
        }
    }
    else{
        header('Location: ../index.php?url=login');
        exit;
    }

?>