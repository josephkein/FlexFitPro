
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
<body>
    <!-- SIDE BAR -->
        <aside class="hidden md:flex flex-col gap-6 bg-violet-600 h-screen max-w-sm w-full py-6 shrink">
            <div class="flex gap-4 px-10 items-center cursor-pointer">
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
                    <a href="./index.php?url=admin" class="flex gap-4 items-center">
                        <div class="">
                            <img src="./images/layout.png" alt="">
                        </div>
                        <span class="text-white text-xl">Dashboard</span>
                    </a>
                    <a href="./index.php?url=customers" class="flex gap-4">
                        <div class="">
                            <img src="./images/friends.png" alt="">
                        </div>
                        <span class="text-white text-xl">Customers</span>
                    </a>
                    <a href="./index.php?url=trainers" class="flex gap-4">
                        <div class="">
                            <img src="./images/trainer.png" alt="">
                        </div>
                        <span class="text-white text-xl">Trainers</span>
                    </a>
                    <a href="./index.php?url=assign" class="flex gap-4">
                        <div class="">
                            <img src="./images/file.png" alt="">
                        </div>
                        <span class="text-white text-xl">Assign-Trainer</span>
                    </a>
                    <a href="./index.php?url=visits" class="flex gap-4">
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
                    <a href="./index.php?url=payments" class="flex gap-4 items-center">
                        <div class="">
                            <img src="./images/credit-card.png" alt="">
                        </div>
                        <span class="text-white text-xl">Payments</span>
                    </a>
                    <a href="./index.php?url=memberships" class="flex gap-4">
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
                    <a href="./index.php?url=staffs" class="flex gap-4 items-center">
                        <div class="./index.php?url=staffs">
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
</body>
</html>