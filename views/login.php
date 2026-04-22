<?php
    session_start();
    if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin' ){
        header('Location: ./index.php?url=admin');
        exit;
    }

    $invalid = $_SESSION['invalid'] ?? '';
    $empty_user = $_SESSION['empty_user'] ?? '';
    $empty_pass = $_SESSION['empty_pass'] ?? '';

    // <?= $empty_pass ? 'border-red-500 focus:outline-red-400' : 'focus:outline-violet-500' ?>
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlexFit Pro Login</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <link rel="stylesheet" href="./assets/output.css"> -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Outfit', sans-serif;
        }
    </style>
    
</head>
<body class="flex items-center justify-center h-screen w-screen bg-gray-100 px-4">
    <div class="flex w-full max-w-md md:max-w-4xl shadow-lg rounded h-150">
        <div class="hidden md:flex flex-1 flex-col items-center justify-center bg-violet-600 w-full h-full rounded">
            <div>
                <img src="./images/flexfit.png" alt="">
            </div>
        </div>
        <form id="login" method="post" class="bg-white flex-1 flex flex-col justify-center gap-6 w-full h-full px-6 py-6 md:py-2 rounded">
            <div class="w-full flex flex-col gap-2 items-center">
                <div class="text-3xl text-center font-medium">Welcome, Back!</div>
                <span class="text-gray-500 text-center">Enter your admin or staff credentials to continue</span>
            </div>
            <span class="hidden flex justify-center w-full p-2 text-lg text-red-500 bg-red-100 rounded" id="error-head"></span>
            <div class="flex flex-col gap-2">
                <div class="relative flex flex-col gap-2">
                    <label for="user" class="">Username:</label>
                    <div class="absolute top-10 left-3">
                        <img src="./images/user.png" alt="">
                    </div>
                    <input type="text" name="user" id="user" class="border rounded py-2 px-11">
                    <span class="text-red-500" id="error_required"></span>
                </div>
                <div class="relative flex flex-col gap-2">
                    <label for="pass" class="">Password:</label>
                    <div class="absolute top-10 left-3">
                        <img src="./images/padlock.png" alt="">
                    </div>
                    <input type="password" name="pass" id="pass" class="border rounded py-2 px-11">
                    <span class="text-red-500" id="error_required"></span>
                    <label for="show" class="flex gap-2">
                        <input type="checkbox" name="show" id="show" onclick="showPass()">Show password
                    </label>
                </div>
            </div>
            <button type="submit" class="py-2 bg-violet-600 text-white w-full text-lg rounded font-medium" id="loginBtn">Sign in</button>
            <div class="flex flex-col gap-8">
                <hr class="border border-gray-200">
                <span class="text-gray-500 text-center text-sm">© 2026 FlexFit Pro. All rights reserved.</span>
            </div>
        </form>
    </div>
    <script src="./assets/js/auth.js">
    </script>
</body>
</html>