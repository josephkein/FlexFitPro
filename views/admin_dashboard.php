<?php

    session_start();
    if (!isset($_SESSION['role']) && !$_SESSION['role'] && $_SESSION['role'] != 'admin'){
        header('Location: ./index.php?url=login');
        exit;
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="./assets/output.css"> -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <title>Dashboard</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>
<body class="h-screen">
   <div class="flex bg-gray-100 h-full w-full">
    <!-- SIDE BAR -->
        <aside class="hidden md:flex flex-col gap-6 bg-violet-600 h-full max-w-sm w-full py-6 shrink">
            <div class="flex gap-4 px-10 items-center">
                <div class="flex items-center justify-center bg-violet-400 p-2 rounded-xl h-15 w-15">
                    <img src="./images/flexfit.png" alt="logo" class="h-full w-full">
                </div>
                <div class="flex flex-col">
                    <div class="text-white font-bold text-2xl">FlexFit Pro</div>
                    <span class="text-md text-violet-200">Gym Management</span>
                </div>
            </div>
            <!-- main -->
            <div class="flex flex-col gap-2 border-t-2 border-violet-500 pt-4">
                <div class="text-violet-200 font-medium px-10 text-md">MAIN</div>
                <nav class="flex flex-col [&>a]:hover:bg-violet-500 [&>a]:py-3 [&>a]:px-10">
                    <a href="" class="flex gap-4 items-center">
                        <div class="">
                            <img src="./images/layout.png" alt="">
                        </div>
                        <span class="text-white text-xl">Dashboard</span>
                    </a>
                    <a href="" class="flex gap-4">
                        <div class="">
                            <img src="./images/friends.png" alt="">
                        </div>
                        <span class="text-white text-xl">Customers</span>
                    </a>
                    <a href="" class="flex gap-4">
                        <div class="">
                            <img src="./images/trainer.png" alt="">
                        </div>
                        <span class="text-white text-xl">Trainers</span>
                    </a>
                    <a href="" class="flex gap-4">
                        <div class="">
                            <img src="./images/file.png" alt="">
                        </div>
                        <span class="text-white text-xl">Visit Log</span>
                    </a>
                </nav>
            </div>
            <!-- finance -->
            <div class="flex flex-col gap-2 border-t-2 border-violet-500 pt-4">
                <div class="text-violet-200 font-medium px-10 text-md">FINANCE</div>
                <nav class="flex flex-col [&>a]:hover:bg-violet-500 [&>a]:py-3 [&>a]:px-10">
                    <a href="" class="flex gap-4 items-center">
                        <div class="">
                            <img src="./images/credit-card.png" alt="">
                        </div>
                        <span class="text-white text-xl">Payments</span>
                    </a>
                    <a href="" class="flex gap-4">
                        <div class="">
                            <img src="./images/member.png" alt="">
                        </div>
                        <span class="text-white text-xl">Memberships</span>
                    </a>
                </nav>
            </div>
            <div class="flex flex-col gap-2 border-t-2 border-violet-500 pt-4">
                <div class="text-violet-200 font-medium px-10 text-md">ADMIN</div>
                <nav class="flex flex-col [&>a]:hover:bg-violet-500 [&>a]:py-3 [&>a]:px-10">
                    <a href="" class="flex gap-4 items-center">
                        <div class="">
                            <img src="./images/friends.png" alt="">
                        </div>
                        <span class="text-white text-xl">Staff accounts</span>
                    </a>
                </nav>
            </div>
            <div class="flex flex-col gap-2 border-t-2 border-violet-500 pt-4">
                <nav class="flex flex-col [&>a]:hover:bg-violet-500 [&>a]:py-3 [&>a]:px-10">
                    <a href="./actions/logout.php" class="flex gap-4 items-center">
                        <div class="">
                            <img src="./images/out.png" alt="">
                        </div>
                        <span class="text-white text-xl">Log out</span>
                    </a>
                </nav>
            </div>
        </aside>
        <!-- MAIN CONTENTS -->
        <div class="flex flex-col w-full">
            <header class="flex justify-between items-center px-10 py-4 bg-white border-b-1 border-violet-200">
                <div class="text-2xl font-medium">Dashboard Overview</div>
                <div class="flex items-center gap-4">
                    <span class="flex items-center justify-center rounded-full text-xl text-white font-bold p-3 bg-violet-500"><?= strtoupper($_SESSION['role'][0] . $_SESSION['role'][1]) ?></span>
                </div>
            </header>
            <main class="flex flex-col w-full px-6 mt-5 gap-6">  
                <div class="flex flex-col gap-2 w-full">
                    <div class="text-gray-500 font-medium">KEY METRICS</div>
                    <div class="flex gap-4 flex-wrap">

                        <div class="flex flex-1 flex-col justify-center gap-2 p-4 bg-white shadow-md rounded border-l-2 border-violet-600 w-full">
                            <div class="flex justify-between">
                                <span class="text-gray-400">Total Revenue</span>
                                <div>
                                    <img src="" alt="">
                                </div>
                            </div>
                            <div class="text-3xl font-bold">$482,300</div>
                            <span class="text-sm text-green-500">+12.4% vs last month</span>
                        </div>

                        <div class="flex flex-1 flex-col justify-center gap-2 p-4 bg-white shadow-md rounded border-l-2 border-violet-600 w-full">
                            <div class="flex justify-between">
                                <span class="text-gray-400">Daily Revenue</span>
                                <div>
                                    <img src="" alt="">
                                </div>
                            </div>
                            <div class="text-3xl font-bold">$42,300</div>
                            <span class="text-sm text-green-500">+12.4% vs last month</span>
                        </div>

                        <div class="flex flex-1 flex-col justify-center gap-2 p-4 bg-white shadow-md rounded border-l-2 border-violet-600 w-full">
                            <div class="flex justify-between">
                                <span class="text-gray-400">Total Visits</span>
                                <div>
                                    <img src="" alt="">
                                </div>
                            </div>
                            <div class="text-3xl font-bold">484</div>
                            <span class="text-sm text-green-500">+12.4% vs last month</span>
                        </div>

                        <div class="flex flex-1 flex-col justify-center gap-2 p-4 bg-white shadow-md rounded border-l-2 border-violet-600 w-full">
                            <div class="flex justify-between">
                                <span class="text-gray-400">Monthly Visits</span>
                                <div>
                                    <img src="" alt="">
                                </div>
                            </div>
                            <div class="text-3xl font-bold">789</div>
                            <span class="text-sm text-green-500">+12.4% vs last month</span>
                        </div>

                    </div>
                </div>
                <!-- ANALYTICS CHARTS -->
                <div class="analytics">
                    <div class="flex flex-col gap-2 w-full">
                        <div class="text-gray-500 font-medium">ANALYTICS</div>
                        <div class="flex flex-wrap gap-4">
                            <div class="flex flex-1 flex-col gap-4 bg-white p-6 rounded-lg shadow-md">
                                <div class="flex justify-between">
                                    <span class="text-2xl">Monthly Revenue</span>
                                    <span class="flex items-center text-violet-600 bg-violet-100 px-3 rounded-2xl">2026</span>
                                </div>
                                <div class="w-full">
                                    <div id="chart"></div>
                                </div>
                            </div>
                            <div class="flex flex-1 flex-col gap-4 bg-white p-6 rounded-lg shadow-md">
                                <div class="flex justify-between">
                                    <span class="text-2xl">Daily Visits</span>
                                    <span class="flex items-center text-violet-600 bg-violet-100 px-3 rounded-2xl">This Week</span>
                                </div>
                                <div class="w-full">
                                    <div id="visitsChart" class="h-80 w-full"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RECENT ACTIVITIES -->
                <div class="">

                </div>
            </main>
        </div>
   </div>

   <script src="./assets/admin.js"></script>

</body>
</html>