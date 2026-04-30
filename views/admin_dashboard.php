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
    <link rel="shortcut icon" href="./images/flexfit.png" type="image/x-icon">
    <title>Dashboard</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen">
   <div class="flex bg-gray-100 h-full w-full">
    <!-- SIDE BAR -->
        <?php include './views/sidebar.php' ?>
        <!-- MAIN CONTENTS -->
        <div class="flex flex-col w-full overflow-auto h-screen pb-10">
            <?php include './views/header.php'?>
            <main class="flex flex-col w-full px-6 mt-5 gap-6">  
                <div class="flex flex-col gap-4 w-full">
                    <div class="flex flex-col gap-1">
                        <span class="text-3xl font-medium">Dashboard</span>
                        <span class="text-gray-500 text-lg">Overview of gym revenue, visits, and activity analytics.</span>
                    </div>
                    <div class="flex gap-4 flex-wrap">

                        <div class="flex flex-1 flex-col justify-center p-4 bg-white shadow-md rounded border-l-2 border-violet-600 w-full">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">Total Revenue</span>
                                <div class="p-2 bg-violet-100 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="26" height="26" viewBox="0 0 20 20" style="color: rgb(128, 82, 246);"><g fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"><path d="M11 3.5H6v-2h5a5 5 0 0 1 5 5v1a5 5 0 0 1-5 5H6v-2h5a3 3 0 0 0 3-3v-1a3 3 0 0 0-3-3"></path><path d="M6 1.5a1 1 0 0 1 1 1V18a1 1 0 1 1-2 0V2.5a1 1 0 0 1 1-1"></path><path d="M2 5.436a1 1 0 0 1 1-1h14a1 1 0 1 1 0 2H3a1 1 0 0 1-1-1m0 3a1 1 0 0 1 1-1h14a1 1 0 1 1 0 2H3a1 1 0 0 1-1-1"></path></g></svg>
                                </div>
                            </div>
                            <div class="text-3xl font-bold" id="total_revenue">₱0</div>
                        </div>

                        <div class="flex flex-1 flex-col justify-center gap-2 p-4 bg-white shadow-md rounded border-l-2 border-violet-600 w-full">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">Daily Revenue</span>
                                <div class="p-2 bg-blue-100 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="26" height="26" viewBox="0 0 24 24" style="color: rgb(58, 118, 245);"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M2 7a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2z"></path><circle cx="12" cy="12" r="3"></circle><path d="M2 9a4 4 0 0 0 4-4v0m12 14a4 4 0 0 1 4-4v0"></path></g></svg>
                                </div>
                            </div>
                            <div class="text-3xl font-bold" id="daily_revenue">₱0</div>
                        </div>

                        <div class="flex flex-1 flex-col justify-center gap-2 p-4 bg-white shadow-md rounded border-l-2 border-violet-600 w-full">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">Total Visits</span>
                                <div class="p-2 bg-green-100 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="26" height="26" viewBox="0 0 24 24" style="color: rgb(124, 197, 4);"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8h7a3 3 0 1 0-3-3M4 16h11a3 3 0 1 1-3 3M2 12h17a3 3 0 1 0-3-3"></path></svg>
                                </div>
                            </div>
                            <div class="text-3xl font-bold" id="total_visit">0</div>
                        </div>

                        <div class="flex flex-1 flex-col justify-center gap-2 p-4 bg-white shadow-md rounded border-l-2 border-violet-600 w-full">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">Monthly Visits</span>
                                <div class="p-2 bg-orange-100 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="26" height="26" viewBox="0 0 24 24" style="color: rgb(228, 171, 0);"><path fill="currentColor" fill-rule="evenodd" d="M12.153 3.802c3.734.067 7.309 2.237 9.228 6.14a4.79 4.79 0 0 1 0 4.217c-1.92 3.902-5.494 6.072-9.228 6.14c-3.75.067-7.427-1.99-9.532-6.003a4.84 4.84 0 0 1 0-4.492c2.105-4.013 5.781-6.07 9.532-6.002m-7.761 6.932c3.545-6.759 11.99-6.425 15.195.09c.379.77.379 1.681 0 2.452c-3.205 6.515-11.65 6.849-15.195.09a2.84 2.84 0 0 1 0-2.632" clip-rule="evenodd"></path><path fill="currentColor" fill-rule="evenodd" d="M15.7 12.05a3.75 3.75 0 1 1-7.5 0a3.75 3.75 0 0 1 7.5 0m-3.75 1.75a1.75 1.75 0 1 0 0-3.5a1.75 1.75 0 0 0 0 3.5" clip-rule="evenodd"></path></svg>
                                </div>
                            </div>
                            <div class="text-3xl font-bold" id="monthly_visit">0</div>
                        </div>

                    </div>
                </div>
                <!-- ANALYTICS CHARTS -->
                <div class="analytics">
                    <div class="flex flex-col gap-2 w-full">
                        <div class="flex flex-wrap md:flex-nowrap gap-4">
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
                <div id="map" class="bg-white shadow-lg h-200 w-full px-6">
                </div>
            </main>
        </div>
   </div>

   <script src="./assets/js/admin.js"></script>

</body>
</html>