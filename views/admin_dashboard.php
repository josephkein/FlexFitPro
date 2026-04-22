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
        <?php include './views/sidebar.php' ?>
        <!-- MAIN CONTENTS -->
        <div class="flex flex-col w-full">
            <?php include './views/header.php'?>
            <main class="flex flex-col w-full px-6 mt-5 gap-6">  
                <div class="flex flex-col gap-4 w-full">
                    <div class="flex flex-col gap-1">
                        <span class="text-3xl font-medium">Dashboard</span>
                        <span class="text-gray-500 text-lg">Overview of gym revenue, visits, and activity analytics.</span>
                    </div>
                    <div class="flex gap-4 flex-wrap">

                        <div class="flex flex-1 flex-col justify-center gap-2 p-4 bg-white shadow-md rounded border-l-2 border-violet-600 w-full">
                            <div class="flex justify-between">
                                <span class="text-gray-400">Total Revenue</span>
                                <div>
                                    <img src="" alt="">
                                </div>
                            </div>
                            <div class="text-3xl font-bold" id="total_revenue">$482,300</div>
                        </div>

                        <div class="flex flex-1 flex-col justify-center gap-2 p-4 bg-white shadow-md rounded border-l-2 border-violet-600 w-full">
                            <div class="flex justify-between">
                                <span class="text-gray-400">Daily Revenue</span>
                                <div>
                                    <img src="" alt="">
                                </div>
                            </div>
                            <div class="text-3xl font-bold" id="daily_revenue">$0</div>
                        </div>

                        <div class="flex flex-1 flex-col justify-center gap-2 p-4 bg-white shadow-md rounded border-l-2 border-violet-600 w-full">
                            <div class="flex justify-between">
                                <span class="text-gray-400">Total Visits</span>
                                <div>
                                    <img src="" alt="">
                                </div>
                            </div>
                            <div class="text-3xl font-bold" id="total_visit">0</div>
                        </div>

                        <div class="flex flex-1 flex-col justify-center gap-2 p-4 bg-white shadow-md rounded border-l-2 border-violet-600 w-full">
                            <div class="flex justify-between">
                                <span class="text-gray-400">Monthly Visits</span>
                                <div>
                                    <img src="" alt="">
                                </div>
                            </div>
                            <div class="text-3xl font-bold" id="monthly_visit">0</div>
                        </div>

                    </div>
                </div>
                <!-- ANALYTICS CHARTS -->
                <div class="analytics">
                    <div class="flex flex-col gap-2 w-full">
                        <div class="flex flex-wrap gap-4">
                            <div class="flex flex-1 flex-col gap-4 bg-white p-6 rounded-lg shadow-md">
                                <div class="flex justify-between">
                                    <span class="text-xl">Monthly Revenue</span>
                                    <span class="flex items-center text-violet-600 bg-violet-100 px-3 rounded-2xl" id="year"></span>
                                </div>
                                <div class="w-full">
                                    <div id="chart"></div>
                                </div>
                            </div>
                            <div class="flex flex-1 flex-col gap-4 bg-white p-6 rounded-lg shadow-md">
                                <div class="flex justify-between">
                                    <span class="text-xl">Daily Visits</span>
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

   <script src="./assets/js/admin.js"></script>

</body>
</html>