<?php
    session_start();
    if (isset($_SESSION['role']) && ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'staff')) {
        header('Location: ./index.php?url=dashboard');
        exit;
    }

    $invalid = $_SESSION['invalid'] ?? '';
    $empty_user = $_SESSION['empty_user'] ?? '';
    $empty_pass = $_SESSION['empty_pass'] ?? '';

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
<body class="bg-gray-100 h-screen px-4">
    <div class="h-screen flex flex-col gap-4 justify-center items-center">
        <div class="flex w-full max-w-md md:max-w-4xl shadow-lg rounded h-150">
            <div class="hidden md:flex flex-1 flex-col items-center justify-center bg-violet-600 w-full h-full rounded">
                <div>
                    <img src="./images/flexfit.png" alt="">
                </div>
            </div>
            <form id="login" method="POST" class="bg-white flex-1 flex flex-col justify-center gap-6 w-full h-full px-6 py-6 md:py-2 rounded">
                <div class="w-full flex flex-col gap-2 items-center">
                    <div class="text-3xl text-center font-medium">Welcome, Back!</div>
                    <span class="text-gray-500 text-center">Enter your admin or staff credentials to continue</span>
                </div>
                <span class="hidden flex justify-center items-center text-center w-full p-2 text-lg text-red-500 bg-red-100 rounded" id="error-head"></span>
                <div class="flex flex-col gap-2">
                    <div class="relative flex flex-col gap-2">
                        <label for="user" class="">Username:</label>
                        <div class="absolute top-10 left-3">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="26" height="26" viewBox="0 0 24 24" style="color: rgb(28, 32, 51);"><path fill="currentColor" d="M12 4a4 4 0 1 0 0 8a4 4 0 0 0 0-8M6 8a6 6 0 1 1 12 0A6 6 0 0 1 6 8m2 10a3 3 0 0 0-3 3a1 1 0 1 1-2 0a5 5 0 0 1 5-5h8a5 5 0 0 1 5 5a1 1 0 1 1-2 0a3 3 0 0 0-3-3z"></path></svg>
                        </div>
                        <input type="text" name="user" id="user" class="border rounded py-2 px-11 focus:outline-violet-500">
                        <span class="text-red-500" id="error_required"></span>
                    </div>
                    <div class="relative flex flex-col gap-2">
                        <label for="pass" class="">Password:</label>
                        <div class="absolute top-10 left-3">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="26" height="26" viewBox="0 0 24 24" style="color: rgb(28, 32, 51);"><path fill="currentColor" d="M12 4c1.648 0 3 1.352 3 3v3H9V7c0-1.648 1.352-3 3-3m5 6V7c0-2.752-2.248-5-5-5S7 4.248 7 7v3H6a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8a2 2 0 0 0-2-2zM6 12h12v8H6z"></path></svg>
                        </div>
                        <input type="password" name="pass" id="pass" class="border rounded py-2 px-11 focus:outline-violet-500">
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
        <span class="text-gray-400">Demo - jkeinskie / 1324</span>
    </div>
    <script src="./assets/js/auth.js">
    </script>
</body>
</html>