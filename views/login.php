<?php
    session_start();

    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    
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
        #right{
            background-image:
            linear-gradient(#7008E7 1px, transparent 1px),
            linear-gradient(90deg, #7008E7 1px, transparent 1px);
            background-size: 110px 110px;
        }
        
    </style>
    
</head>
<body class="bg-gray-100 h-screen px-4">
    <div class="h-screen flex flex-col gap-4 justify-center items-center">
        <div class="flex w-full max-w-md md:max-w-5xl shadow-lg rounded-xl h-150">
            <div id="right" class="hidden md:flex flex-1 flex-col bg-violet-800 w-full h-full rounded-l-xl">
                <div class="flex-2 flex flex-col gap-2 items-center justify-center">
                    <div class="w-20 h-20 rounded-full bg-violet-600 flex items-center justify-center">
                        <img src="./images/logoflex.png" alt="">
                    </div>
                    <div class="flex flex-col text-center">
                        <span class="font-medium text-white text-3xl">FlexFitPro</span>
                        <span class="text-violet-300">Gym Management System</span>
                    </div>
                </div>
                <div class="benifits flex-2 flex flex-col gap-5 px-10">
                    <div class="flex items-center gap-2">
                        <div class="rounded-xl bg-violet-600 p-3 border border-violet-400">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="26" height="26" viewBox="0 0 15 15" style="color: rgb(255, 255, 255);"><path fill="currentColor" d="M5 8.9c1.44 0 2.68.252 3.575.855C9.502 10.38 10 11.343 10 12.6a.501.501 0 0 1-1 0c0-.958-.358-1.596-.983-2.017C7.359 10.141 6.35 9.9 5 9.9s-2.36.241-3.017.684C1.358 11.005 1 11.643 1 12.601a.501.501 0 0 1-1 0c0-1.258.497-2.221 1.424-2.846C2.319 9.152 3.56 8.9 5 8.9m4.975 0c1.439 0 2.68.252 3.575.855c.927.625 1.425 1.588 1.425 2.846a.5.5 0 0 1-1 0c0-.958-.358-1.596-.984-2.017c-.518-.349-1.253-.57-2.202-.65a4.5 4.5 0 0 0-.87-1.033zM5 1.85a3.151 3.151 0 0 1 0 6.3a3.15 3.15 0 1 1 0-6.3m4.975 0a3.15 3.15 0 0 1 0 6.3c-.524 0-1.016-.13-1.45-.356a4.5 4.5 0 0 0 .534-.852a2.15 2.15 0 1 0 0-3.887a4.5 4.5 0 0 0-.535-.85a3.1 3.1 0 0 1 1.45-.355M5 2.85a2.151 2.151 0 0 0 0 4.3a2.15 2.15 0 0 0 0-4.3"></path></svg>
                        </div>
                        <span class="text-white text-lg">Customer & Member Management</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="rounded-xl bg-violet-600 p-3 border border-violet-400">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="26" height="26" viewBox="0 0 16 16" style="color: rgb(255, 255, 255);"><path fill="currentColor" d="M14.5 16h-13C.67 16 0 15.33 0 14.5v-12C0 1.67.67 1 1.5 1h13c.83 0 1.5.67 1.5 1.5v12c0 .83-.67 1.5-1.5 1.5M1.5 2c-.28 0-.5.22-.5.5v12c0 .28.22.5.5.5h13c.28 0 .5-.22.5-.5v-12c0-.28-.22-.5-.5-.5z"></path><path fill="currentColor" d="M4.5 4c-.28 0-.5-.22-.5-.5v-3c0-.28.22-.5.5-.5s.5.22.5.5v3c0 .28-.22.5-.5.5m7 0c-.28 0-.5-.22-.5-.5v-3c0-.28.22-.5.5-.5s.5.22.5.5v3c0 .28-.22.5-.5.5m4 2H.5C.22 6 0 5.78 0 5.5S.22 5 .5 5h15c.28 0 .5.22.5.5s-.22.5-.5.5"></path></svg>                        
                        </div>
                        <span class="text-white text-lg">Visit Logging & Attendance Tracking</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="rounded-xl bg-violet-600 p-3 border border-violet-400">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="26" height="26" viewBox="0 0 24 24" style="color: rgb(255, 255, 255);"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2v20m4-17h-6a3.5 3.5 0 0 0 0 7h4.5a3.5 3.5 0 0 1 0 7H6"></path></svg>              
                        </div>
                        <span class="text-white text-lg">Payment & Revenue Analytics</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="rounded-xl bg-violet-600 p-3 border border-violet-400">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="26" height="26" viewBox="0 0 24 24" style="color: rgb(255, 255, 255);"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m13.147 21.197l1.67-1.168a13.39 13.39 0 0 0 5.447-13.624a.84.84 0 0 0-.453-.586L12 2L4.19 5.819a.84.84 0 0 0-.454.586a13.39 13.39 0 0 0 5.448 13.624l1.67 1.168a2 2 0 0 0 2.293 0"></path></svg>                        
                        </div>    
                        <span class="text-white text-lg">Role-Based Staff Access Control</span>
                    </div>
                </div>
                <div class="flex-1 flex items-center justify-center">
                    <span class="text-gray-300 text-center text-sm">© 2026 FlexFit Pro. All rights reserved.</span>
                </div>
            </div>
            <div class="flex-1">
            <form id="login" method="POST" class="bg-white flex-1 flex flex-col justify-center gap-6 w-full h-full px-8 md:px-10 py-6 md:py-2 rounded-r-xl">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                <div class="w-full flex flex-col gap-2 items-center">
                    <div class="text-3xl text-center font-medium">Welcome, Back!</div>
                    <span class="text-gray-500 text-center">Sign in to your <span class="text-violet-800 font-medium">FlexFitPro</span> dashboard and manage your gym operations</span>
                </div>
                <span class="hidden flex justify-center items-center text-center w-full p-2 text-lg text-red-500 bg-red-100 rounded" id="error-head"></span>
                <div class="flex flex-col gap-2">
                    <div class="relative flex flex-col gap-2">
                        <label for="user" class="">Username:</label>
                        <div class="absolute top-11 left-3">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="26" height="26" viewBox="0 0 24 24" style="color: rgb(28, 32, 51);"><path fill="currentColor" d="M12 4a4 4 0 1 0 0 8a4 4 0 0 0 0-8M6 8a6 6 0 1 1 12 0A6 6 0 0 1 6 8m2 10a3 3 0 0 0-3 3a1 1 0 1 1-2 0a5 5 0 0 1 5-5h8a5 5 0 0 1 5 5a1 1 0 1 1-2 0a3 3 0 0 0-3-3z"></path></svg>
                        </div>
                        <input type="text" name="user" id="user" class="border border-gray-400 rounded-lg py-2.5 text-lg px-11 focus:outline-none focus:ring-2 focus:ring-violet-400 focus:border-violet-500 w-full">
                        <span class="text-red-500" id="error_required"></span>
                    </div>
                    <div class="relative flex flex-col gap-2">
                        <label for="pass" class="">Password:</label>
                        <div class="absolute top-11 left-3">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="26" height="26" viewBox="0 0 24 24" style="color: rgb(28, 32, 51);"><path fill="currentColor" d="M12 4c1.648 0 3 1.352 3 3v3H9V7c0-1.648 1.352-3 3-3m5 6V7c0-2.752-2.248-5-5-5S7 4.248 7 7v3H6a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8a2 2 0 0 0-2-2zM6 12h12v8H6z"></path></svg>
                        </div>
                        <input type="password" name="pass" id="pass" class="border border-gray-400 rounded-lg py-2.5 text-lg px-11 focus:outline-none focus:ring-2 focus:ring-violet-400 focus:border-violet-500 w-full">
                        <span class="text-red-500" id="error_required"></span>
                        <label for="show" class="flex gap-2">
                            <input type="checkbox" name="show" id="show" onclick="showPass()">Show password
                        </label>
                    </div>
                </div>
                <button type="submit" class="py-2.5 bg-violet-800 text-white w-full text-lg rounded font-medium" id="loginBtn">Sign in</button>
                <div class="flex flex-col gap-8">
                    <hr class="border border-gray-200">
                    <span class="text-gray-500 text-center text-sm">Secured with role-based access & session authentication</span>
                </div>
            </form>
            </div>
        </div>
        <span class="text-gray-400">Demo - user / 1324 </span>
    </div>
    <script src="./assets/js/auth.js">
    </script>
</body>
</html>