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
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Visit Log</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap');
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="h-screen">
   <div class="flex bg-gray-100 h-full w-full">
    <!-- SIDE BAR -->
        <?php include './views/sidebar.php' ?>


        <!-- MAIN CONTENTS -->
        <div class="flex flex-col w-full overflow-auto">
            <header class="flex justify-between items-center px-10 py-4 bg-white border-b-1 border-violet-200">
                <div class="text-2xl font-medium">Visit Log</div>
                <div class="flex items-center gap-4">
                    <span class="flex items-center justify-center rounded-full text-xl text-white font-bold p-3 bg-violet-500"><?= strtoupper($_SESSION['role'][0] . $_SESSION['role'][1]) ?></span>
                </div>
            </header>

            <main class="flex flex-col w-full px-6 mt-5 gap-6">


                <!-- TOOLBAR -->
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-2 bg-white border border-gray-200 rounded px-4 py-2 w-full max-w-sm">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" placeholder="Search by name or member ID..." class="outline-none text-md w-full">
                    </div>
                    <div class="flex gap-3 items-center flex-wrap">
                        <input type="date" value="<?= date('Y-m-d') ?>" class="border border-gray-200 rounded px-3 py-2 text-md bg-white outline-none focus:border-violet-400">
                        <select class="border border-gray-200 rounded px-3 py-2 text-md bg-white">
                            <option value="">All Status</option>
                            <option value="checkedin">Checked In</option>
                            <option value="completed">Completed</option>
                        </select>
                        <button class="flex items-center gap-2 border border-violet-600 text-violet-600 hover:bg-violet-50 px-4 py-2 rounded text-md font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                            Export CSV
                        </button>
                    </div>
                </div>

                <!-- TABLE -->
                <div class="bg-white shadow-md rounded overflow-auto">
                    <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
                        <span class="font-medium">Visit Log — <?= date('F d, Y') ?></span>
                        <span class="text-sm text-gray-400">0 entries</span>
                    </div>
                    <table class="w-full text-sm">
                        <thead class="text-gray-400 text-xs uppercase border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left">Member</th>
                                <th class="px-6 py-3 text-left">Member ID</th>
                                <th class="px-6 py-3 text-left">Check-in</th>
                                <th class="px-6 py-3 text-left">Check-out</th>
                                <th class="px-6 py-3 text-left">Duration</th>
                                <th class="px-6 py-3 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            <tr>
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-2">
                                        <span class="w-8 h-8 rounded-full bg-violet-500 text-white flex items-center justify-center text-xs font-bold">JR</span>
                                        Juan Reyes
                                    </div>
                                </td>
                                <td class="px-6 py-3 text-gray-400">MBR-0041</td>
                                <td class="px-6 py-3">6:12 AM</td>
                                <td class="px-6 py-3">7:45 AM</td>
                                <td class="px-6 py-3">93 min</td>
                                <td class="px-6 py-3"><span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-full">Completed</span></td>
                            </tr>
                            <tr>
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-2">
                                        <span class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center text-xs font-bold">MC</span>
                                        Maria Cruz
                                    </div>
                                </td>
                                <td class="px-6 py-3 text-gray-400">MBR-0039</td>
                                <td class="px-6 py-3">7:01 AM</td>
                                <td class="px-6 py-3">8:30 AM</td>
                                <td class="px-6 py-3">89 min</td>
                                <td class="px-6 py-3"><span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-full">Completed</span></td>
                            </tr>
                            <tr>
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-2">
                                        <span class="w-8 h-8 rounded-full bg-yellow-500 text-white flex items-center justify-center text-xs font-bold">AL</span>
                                        Angelo Lim
                                    </div>
                                </td>
                                <td class="px-6 py-3 text-gray-400">MBR-0035</td>
                                <td class="px-6 py-3">5:30 PM</td>
                                <td class="px-6 py-3">—</td>
                                <td class="px-6 py-3">Active</td>
                                <td class="px-6 py-3"><span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">Checked In</span></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="flex justify-between items-center px-6 py-4 border-t border-gray-100">
                        <span class="text-sm text-gray-400">Showing 1–10 of 0 results</span>
                        <div class="flex gap-2">
                            <button class="px-3 py-1 text-sm border border-gray-200 rounded hover:bg-violet-50">Prev</button>
                            <button class="px-3 py-1 text-sm border border-violet-600 bg-violet-600 text-white rounded">1</button>
                            <button class="px-3 py-1 text-sm border border-gray-200 rounded hover:bg-violet-50">Next</button>
                        </div>
                    </div>
                </div>

            </main>
        </div>
   </div>
</body>
</html>
