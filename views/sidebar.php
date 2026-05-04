<?php

    $url = $_GET['url'] ?? '';
?>
<div id="overlay" class="fixed inset-0 bg-black/50 hidden md:hidden z-40"></div>
<!-- SIDE BAR -->
<aside id="aside" class="fixed md:relative z-50 -translate-x-full md:translate-x-0 transition-transform flex flex-col gap-6 bg-violet-800 h-screen w-70 md:w-80 py-6">

    <!-- LOGO -->
    <a href="./index.php" class="flex justify-between px-5 md:px-10">
        <div class="flex gap-4 items-center cursor-pointer">
            <div class="flex items-center justify-center bg-violet-700 rounded-xl h-10 w-10 md:h-14 md:w-14">
                <img src="./images/logoflex.png" alt="logo" class="h-full w-full">
            </div>

            <div class="flex flex-col">
                <div class="text-white font-bold text-lg md:text-2xl">FlexFit Pro</div>
                <span class="text-sm md:text-md text-violet-200">Gym Management</span>
            </div>
        </div>
        <button id="close" class="md:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="25" height="25" viewBox="0 0 24 24" style="color: rgb(255, 255, 255);"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5l7 7l7 -7M12 12h0M5 19l7 -7l7 7"><animate fill="freeze" attributeName="d" dur="0.4s" values="M5 5l7 0l7 0M5 12h14M5 19l7 0l7 0;M5 5l7 7l7 -7M12 12h0M5 19l7 -7l7 7"></animate></path></svg>
        </button>
    </a>

    <!-- MAIN -->
    <div class="flex flex-col gap-2 border-t-2 border-violet-700 pt-4">
        <div class="text-violet-200 font-medium px-5 md:px-10 text-sm md:text-md">MAIN</div>

        <nav class="flex flex-col">

            <a href="./index.php?url=dashboard" class="flex gap-3 md:gap-4 items-center px-5 md:px-10 py-2 md:py-3 <?= $url == 'dashboard' ? 'bg-violet-700' : '' ?> hover:bg-violet-700">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="26" height="26" viewBox="0 0 24 24" style="color: rgb(255, 255, 255);"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 5a2 2 0 0 1 2-2h6v18H4a2 2 0 0 1-2-2zm12-2h6a2 2 0 0 1 2 2v5h-8zm0 11h8v5a2 2 0 0 1-2 2h-6z"></path></svg>
                <span class="text-white text-base md:text-xl">Dashboard</span>
            </a>

            <a href="./index.php?url=customers" class="flex gap-3 md:gap-4 items-center px-5 md:px-10 py-2 md:py-3 <?= $url == 'customers' ? 'bg-violet-700' : '' ?> hover:bg-violet-700">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="26" height="26" viewBox="0 0 16 16" style="color: rgb(255, 255, 255);"><path fill="currentColor" d="M15 14s1 0 1-1s-1-4-5-4s-5 3-5 4s1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276c.593.69.758 1.457.76 1.72l-.008.002l-.014.002zM11 7a2 2 0 1 0 0-4a2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0a3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904c.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724c.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0a3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4a2 2 0 0 0 0-4"></path></svg>
                <span class="text-white text-base md:text-xl">Customers</span>
            </a>

            <a href="./index.php?url=trainers" class="flex gap-3 md:gap-4 items-center px-5 md:px-10 py-2 md:py-3 <?= $url == 'trainers' ? 'bg-violet-700' : '' ?> hover:bg-violet-700">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="26" height="26" viewBox="0 0 50 50" style="color: rgb(255, 255, 255);"><path fill="currentColor" d="M17.96 44.87c.37.4.35 1.04-.05 1.42l-2.17 2.03c-.4.38-1.04.35-1.41-.05L1.68 34.64c-.37-.4-.35-1.04.05-1.42l2.17-2.03a.996.996 0 0 1 1.41.05zM34.1 19.22c.37.4.35 1.04-.05 1.42L20.38 33.41c-.4.38-1.04.35-1.41-.05l-3.26-3.52c-.37-.4-.35-1.04.05-1.42l13.67-12.77c.4-.37 1.04-.35 1.41.05l3.27 3.52zm-11.49 21.3c.37.4.35 1.04-.05 1.42l-2.17 2.03c-.4.38-1.04.35-1.41-.05L6.34 30.29c-.37-.4-.35-1.04.05-1.42l2.17-2.03c.4-.37 1.04-.35 1.41.05l12.65 13.63zm21.06-20.81c.37.4.35 1.04-.05 1.42l-2.17 2.03c-.4.38-1.04.35-1.41-.05L27.4 9.48c-.37-.4-.35-1.04.05-1.42l2.18-2.03c.4-.37 1.04-.35 1.41.05l12.64 13.63zm4.64-4.34c.37.4.35 1.04-.05 1.42l-2.17 2.03c-.4.38-1.04.35-1.41-.05L32.04 5.14c-.37-.4-.35-1.04.05-1.42l2.17-2.03a.997.997 0 0 1 1.41.05l12.64 13.64z"></path></svg>
                <span class="text-white text-base md:text-xl">Trainers</span>
            </a>

            <a href="./index.php?url=assign" class="flex gap-3 md:gap-4 items-center px-5 md:px-10 py-2 md:py-3 <?= $url == 'assign' ? 'bg-violet-700' : '' ?> hover:bg-violet-700">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="26" height="26" viewBox="0 0 24 24" style="color: rgb(255, 255, 255);"><g fill="none"><path d="M9.708 2.5a2.5 2.5 0 0 1 4.584 0H20.5v19h-17v-19z" clip-rule="evenodd"></path><path stroke="currentColor" stroke-linecap="square" stroke-width="2" d="M9.708 2.5a2.5 2.5 0 0 1 4.584 0H20.5v19h-17v-19z" clip-rule="evenodd"></path><path stroke="currentColor" stroke-linecap="square" stroke-width="2" d="m7.758 12.414l2.828 2.829l5.657-5.657"></path></g></svg>
                <span class="text-white text-base md:text-xl">Assign-Trainer</span>
            </a>

            <a href="./index.php?url=visits" class="flex gap-3 md:gap-4 items-center px-5 md:px-10 py-2 md:py-3 <?= $url == 'visits' ? 'bg-violet-700' : '' ?> hover:bg-violet-700">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="26" height="26" viewBox="0 0 24 24" style="color: rgb(255, 255, 255);"><g fill="none"><path d="M9.708 2.5a2.5 2.5 0 0 1 4.584 0H20.5v19h-17v-19z" clip-rule="evenodd"></path><path stroke="currentColor" stroke-linecap="square" stroke-width="2" d="M9.708 2.5a2.5 2.5 0 0 1 4.584 0H20.5v19h-17v-19z" clip-rule="evenodd"></path><path stroke="currentColor" stroke-linecap="square" stroke-width="2" d="M17 18a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3m7.5-8.5a2.5 2.5 0 1 1-5 0a2.5 2.5 0 0 1 5 0Z"></path></g></svg>
                <span class="text-white text-base md:text-xl">Visit Log</span>
            </a>

        </nav>
    </div>

    <!-- FINANCE -->
    <div class="flex flex-col gap-2 border-t-2 border-violet-500 pt-4">
        <div class="text-violet-200 font-medium px-5 md:px-10 text-sm md:text-md">FINANCE</div>

        <nav class="flex flex-col">

            <a href="./index.php?url=payments" class="flex gap-3 md:gap-4 items-center px-5 md:px-10 py-2 md:py-3 <?= $url == 'payments' ? 'bg-violet-700' : '' ?> hover:bg-violet-700">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="26" height="26" viewBox="0 0 24 24" style="color: rgb(255, 255, 255);"><g fill="none" stroke="currentColor" stroke-width="1.5"><path d="M2 12c0-3.771 0-5.657 1.172-6.828S6.229 4 10 4h4c3.771 0 5.657 0 6.828 1.172S22 8.229 22 12s0 5.657-1.172 6.828S17.771 20 14 20h-4c-3.771 0-5.657 0-6.828-1.172S2 15.771 2 12Z"></path><path stroke-linecap="round" d="M10 16H6m8 0h-1.5M2 10h20"></path></g></svg>
                <span class="text-white text-base md:text-xl">Payments</span>
            </a>

            <a href="./index.php?url=memberships" class="flex gap-3 md:gap-4 items-center px-5 md:px-10 py-2 md:py-3 <?= $url == 'memberships' ? 'bg-violet-700' : '' ?> hover:bg-violet-700">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="26" height="26" viewBox="0 0 24 24" style="color: rgb(255, 255, 255);"><path fill="currentColor" d="M22 3H2c-1.09.04-1.96.91-2 2v14c.04 1.09.91 1.96 2 2h20c1.09-.04 1.96-.91 2-2V5a2.074 2.074 0 0 0-2-2m0 16H2V5h20zm-8-2v-1.25c0-1.66-3.34-2.5-5-2.5s-5 .84-5 2.5V17zM9 7a2.5 2.5 0 0 0-2.5 2.5A2.5 2.5 0 0 0 9 12a2.5 2.5 0 0 0 2.5-2.5A2.5 2.5 0 0 0 9 7m5 0v1h6V7zm0 2v1h6V9zm0 2v1h4v-1z"></path></svg>
                <span class="text-white text-base md:text-xl">Memberships</span>
            </a>

        </nav>
    </div>
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
    <!-- ADMIN -->
    <div class="flex flex-col gap-2 border-t-2 border-violet-700 pt-4">
        <div class="text-violet-200 font-medium px-5 md:px-10 text-sm md:text-md">ADMIN</div>

        <nav class="flex flex-col">

            <a href="./index.php?url=staffs" class="flex gap-3 md:gap-4 items-center px-5 md:px-10 py-2 md:py-3 <?= $url == 'staffs' ? 'bg-violet-700' : '' ?> hover:bg-violet-700">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="26" height="26" viewBox="0 0 24 24" style="color: rgb(255, 255, 255);"><path fill="currentColor" d="M12 4a4 4 0 1 0 0 8a4 4 0 0 0 0-8M6 8a6 6 0 1 1 12 0A6 6 0 0 1 6 8m2 10a3 3 0 0 0-3 3a1 1 0 1 1-2 0a5 5 0 0 1 5-5h8a5 5 0 0 1 5 5a1 1 0 1 1-2 0a3 3 0 0 0-3-3z"></path></svg>
                <span class="text-white text-base md:text-xl">Staff accounts</span>
            </a>

        </nav>
    </div>
    <?php endif; ?>

    <!-- LOGOUT -->
    <div class="flex flex-col gap-2 border-t-2 border-violet-700 pt-4">
        <nav class="flex flex-col">
    
            <a class="flex gap-3 md:gap-4 items-center cursor-pointer px-5 md:px-10 py-2 md:py-3 hover:bg-violet-700" id="logout">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="26" height="26" viewBox="0 0 24 24" style="color: rgb(255, 255, 255);"><path fill="currentColor" fill-rule="evenodd" d="M3 5c0-1.1.9-2 2-2h8v2H5v14h8v2H5c-1.1 0-2-.9-2-2zm14.176 6L14.64 8.464l1.414-1.414l4.95 4.95l-4.95 4.95l-1.414-1.414L17.176 13H10.59v-2z"></path></svg>
                <span class="text-white text-base md:text-xl">Log out</span>
            </a>

        </nav>
    </div>

</aside>