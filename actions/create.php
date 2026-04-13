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
        $username = htmlspecialchars(trim($_POST['create_user']));
        $password = htmlspecialchars(trim($_POST['create_pass']));
        $confirm = htmlspecialchars(trim($_POST['confirm_pass']));
        $role = htmlspecialchars($_POST['role']);

        unset($_SESSION['success']);
        unset($_SESSION['errors']);
        $errors = [];
        if (!empty($username) && !empty($password) && !empty($confirm) && !empty($role)){

            if ($password == $confirm){
                $new = $controller->create($username, $password, $role);
                if ($new){
                    $_SESSION['success'] = true;
                }else{
                    $_SESSION['success'] = false;
                }
            }
            else{
                $errors[] = "Password did not match";
            }
        }
        else{
            $errors[] = 'Empty credentials';
        }
        $_SESSION['errors'] = $errors;
        header('Location: ../index.php?url=admin');
        exit;
    }


    function validatePassword($pass){
        if (strlen($pass) < 8){

        }
    }

?>