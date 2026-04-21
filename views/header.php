
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

    <header class="flex justify-between items-center px-6 py-4 bg-white border-b-1 border-violet-200">
        <div class="flex">
            <span class="text-3xl font-medium text-violet-600">Welcome! Admin</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="flex items-center justify-center rounded-full text-xl text-violet-600 font-bold p-3 bg-violet-100"><?= strtoupper($_SESSION['role'][0] . $_SESSION['role'][1]) ?></span>
            <div class="flex flex-col">
                <span class="text-xl">Jkeinskie</span>
                <span class="text-gray-400">Admin</span>
            </div>
        </div>
    </header>
</body>
</html>