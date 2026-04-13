<?php
    session_start();
    unset($_SESSION['role']);
    header('Location: ../index.php?url=login');
    exit;

?>