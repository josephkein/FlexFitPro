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
    <title>Trainers</title>
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
            <?php include './views/header.php'?>

            <main class="flex flex-col w-full px-6 mt-5 gap-6">
                <div class="flex flex-col gap-1">
                        <span class="text-3xl font-medium">Trainers</span>
                        <span class="text-gray-500 text-lg">Manage trainers and track status.</span>
                </div>
                <!-- KEY METRICS -->
                <!-- <div class="flex flex-col gap-2 w-full">
                    <div class="text-gray-500 font-medium">KEY METRICS</div>
                    <div class="flex gap-4 flex-wrap">
                        <div class="flex flex-1 flex-col justify-center gap-2 p-4 bg-white shadow-md rounded border-l-2 border-violet-600">
                            <span class="text-gray-400">Total Trainers</span>
                            <div class="text-3xl font-bold" id="total_trainers">0</div>
                            <span class="text-sm text-green-500">All registered trainers</span>
                        </div>
                        <div class="flex flex-1 flex-col justify-center gap-2 p-4 bg-white shadow-md rounded border-l-2 border-violet-600">
                            <span class="text-gray-400">Active</span>
                            <div class="text-3xl font-bold" id="active_trainers">0</div>
                            <span class="text-sm text-green-500">Available Trainers</span>
                        </div>
                    </div>
                </div> -->

                <!-- TOOLBAR -->
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-2 bg-white border border-gray-200 rounded px-4 py-2 w-full max-w-sm">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" placeholder="Search trainer..." id="searchInput" class="outline-none text-md w-full">
                    </div>
                    <div class="flex gap-3">
                        <select class="border border-gray-200 rounded px-3 py-2 text-md bg-white" id="status">
                            <option value="">All Status</option>
                            <option value="available">Available</option>
                            <option value="full">Full</option>
                        </select>
                        <button onclick="openAddModal()" class="flex items-center gap-2 bg-violet-600 hover:bg-violet-700 text-white px-4 py-2 rounded text-md font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Add Trainer
                        </button>
                    </div>
                </div>

                <!-- TABLE -->
                <div class="bg-white shadow-md rounded overflow-auto">
                    <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
                        <span class="font-medium text-lg">Trainer List</span>
                    </div>  
                    <table class="w-full text-md">
                        <thead class="text-gray-400 text-md uppercase border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left">Name</th>
                                <th class="px-6 py-3 text-left">Rate</th>  
                                <th class="px-6 py-3 text-left">Capacity</th>
                                <th class="px-6 py-3 text-left">Current Trainees</th>
                                <th class="px-6 py-3 text-left">Status</th>
                                <th class="px-6 py-3 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="trainerTable" class="divide-y divide-gray-50">
                            
                        </tbody>
                    </table>
                    <!-- Pagination -->
                    <div id="pagination" class="flex justify-center items-center px-6 py-4 border-t border-gray-100">
                        <div class="flex gap-2">
                            <button class="px-3 py-1 text-md border border-gray-200 rounded hover:bg-violet-50" id="prev">Prev</button>
                            <button class="px-3 py-1 text-md border border-violet-600 bg-violet-600 text-white rounded" id="page">1</button>
                            <button class="px-3 py-1 text-md border border-gray-200 rounded hover:bg-violet-50" id="next">Next</button>
                        </div>
                    </div>
                </div>


            </main>
        </div>
   </div>

   <!-- ADD TRAINER MODAL -->
   <div id="addTrainer" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
       <div class="bg-white rounded-lg shadow-xl w-full max-w-lg mx-4">
           <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
               <span class="font-medium text-xl">Add New Trainer</span>
               <button onclick="closeAddModal()" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
           </div>
           <form method="POST" class="px-6 py-4 flex flex-col gap-4" id="trainerForm">
               <div class="flex flex-col gap-1">
                   <label class="text-md text-gray-500">First Name</label>
                   <input type="text" name="first_name" class="border border-gray-200 rounded px-3 py-2 text-md outline-none focus:border-violet-400" placeholder="Enter full name">
               </div>
               <div class="flex flex-col gap-1">
                   <label class="text-md text-gray-500">Last Name</label>
                   <input type="text" name="last_name" class="border border-gray-200 rounded px-3 py-2 text-md outline-none focus:border-violet-400" placeholder="Enter full name">
               </div>
              
               <div class="flex gap-4">
                   <div class="flex flex-col gap-1 flex-1">
                       <label class="text-md text-gray-500">Rate</label>
                       <input type="number" name="rate" class="border border-gray-200 rounded px-3 py-2 text-md outline-none focus:border-violet-400" placeholder="e.g. 250, 500">
                   </div>
                   <div class="flex flex-col gap-1 flex-1">
                       <label class="text-md text-gray-500">Capacity</label>
                       <input type="number" name="capacity" class="border border-gray-200 rounded px-3 py-2 text-md outline-none focus:border-violet-400" placeholder="e.g. 5, 4">
                   </div>
               </div>
               <div class="flex justify-end gap-3 pt-2">
                   <button type="button" onclick="closeAddModal()" class="px-4 py-2 text-md border border-gray-200 rounded hover:bg-gray-50">Cancel</button>
                   <button type="submit" class="px-4 py-2 text-md bg-violet-600 hover:bg-violet-700 text-white rounded">Save Trainer</button>
               </div>
           </form>
       </div>
   </div>

   <!-- UPDATE MODAL -->
   <div id="updateTrainer" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
       <div class="bg-white rounded-lg shadow-xl w-full max-w-lg mx-4">
           <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
               <span class="font-medium text-xl">Add New Trainer</span>
               <button onclick="closeUpdate()" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
           </div>
           <form method="POST" class="px-6 py-4 flex flex-col gap-4" id="trainerForm">
               <div class="flex flex-col gap-1">
                   <label class="text-md text-gray-500">First Name</label>
                   <input type="text" name="up_first" class="border border-gray-200 rounded px-3 py-2 text-md outline-none focus:border-violet-400" placeholder="Enter full name" required>
               </div>
               <div class="flex flex-col gap-1">
                   <label class="text-md text-gray-500">Last Name</label>
                   <input type="text" name="up_last" class="border border-gray-200 rounded px-3 py-2 text-md outline-none focus:border-violet-400" placeholder="Enter full name" required>
               </div>
              
               <div class="flex gap-4">
                   <div class="flex flex-col gap-1 flex-1">
                       <label class="text-md text-gray-500">Rate</label>
                       <input type="number" name="up_rate" class="border border-gray-200 rounded px-3 py-2 text-md outline-none focus:border-violet-400" placeholder="e.g. 250, 500">
                   </div>
                   <div class="flex flex-col gap-1 flex-1">
                       <label class="text-md text-gray-500">Capacity</label>
                       <input type="number" name="up_cap" class="border border-gray-200 rounded px-3 py-2 text-md outline-none focus:border-violet-400" placeholder="e.g. 5, 4">
                   </div>
               </div>
               <div class="flex justify-end gap-3 pt-2">
                   <button type="button" onclick="closeAddModal()" class="px-4 py-2 text-md border border-gray-200 rounded hover:bg-gray-50">Cancel</button>
                   <button type="submit" class="px-4 py-2 text-md bg-violet-600 hover:bg-violet-700 text-white rounded">Save Trainer</button>
               </div>
           </form>
       </div>
   </div>

   <script src="./assets/js/trainer.js">
   </script>
</body>
</html>
