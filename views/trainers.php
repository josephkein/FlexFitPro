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
            <header class="flex justify-between items-center px-10 py-4 bg-white border-b-1 border-violet-200">
                <div class="text-2xl font-medium">Trainers</div>
                <div class="flex items-center gap-4">
                    <span class="flex items-center justify-center rounded-full text-xl text-white font-bold p-3 bg-violet-500"><?= strtoupper($_SESSION['role'][0] . $_SESSION['role'][1]) ?></span>
                </div>
            </header>

            <main class="flex flex-col w-full px-6 mt-5 gap-6">

                <!-- KEY METRICS -->
                <div class="flex flex-col gap-2 w-full">
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
                </div>

                <!-- TOOLBAR -->
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-2 bg-white border border-gray-200 rounded px-4 py-2 w-full max-w-sm">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" placeholder="Search trainer..." class="outline-none text-md w-full">
                    </div>
                    <div class="flex gap-3">
                        <select class="border border-gray-200 rounded px-3 py-2 text-md bg-white">
                            <option value="">All Status</option>
                            <option value="available">Available</option>
                            <option value="not_available">Not Available</option>
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
                        <tbody id="membersTable" class="divide-y divide-gray-50">
                            <!-- Rows populated via PHP or JS -->
                            <tr>
                                <td class="px-6 py-3">John Doe</td>
                                <td class="px-6 py-3">$300</td>
                                <td class="px-6 py-3">5</td>
                                <td class="px-6 py-3">4</td>
                                <td class="px-6 py-3">Available</td>
                                <td class="px-6 py-3">
                                    <div class="flex gap-2">
                                        <button class="bg-blue-500 p-2 rounded-md text-md">
                                            <img src="./images/edit.png" alt="">
                                        </button>
                                        <button class="bg-red-500 p-2 rounded-md text-md">
                                            <img src="./images/delete.png" alt="">
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-3">Court Justice</td>
                                <td class="px-6 py-3">$100</td>
                                <td class="px-6 py-3">4</td>
                                <td class="px-6 py-3">2</td>
                                <td class="px-6 py-3">Available</td>
                                <td class="px-6 py-3">
                                    <div class="flex gap-2">
                                        <button class="bg-blue-500 p-2 rounded-md text-md">
                                            <img src="./images/edit.png" alt="">
                                        </button>
                                        <button class="bg-red-500 p-2 rounded-md text-md">
                                            <img src="./images/delete.png" alt="">
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-3">Juan Ponce</td>
                                <td class="px-6 py-3">$200</td>
                                <td class="px-6 py-3">3</td>
                                <td class="px-6 py-3">3</td>
                                <td class="px-6 py-3">Not available</td>
                                <td class="px-6 py-3">
                                    <div class="flex gap-2">
                                        <button class="bg-blue-500 p-2 rounded-md text-md">
                                            <img src="./images/edit.png" alt="">
                                        </button>
                                        <button class="bg-red-500 p-2 rounded-md text-md">
                                            <img src="./images/delete.png" alt="">
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>
                    <!-- Pagination -->
                    <div class="flex justify-center items-center px-6 py-4 border-t border-gray-100">
                        <div class="flex gap-2">
                            <button class="px-3 py-1 text-md border border-gray-200 rounded hover:bg-violet-50">Prev</button>
                            <button class="px-3 py-1 text-md border border-violet-600 bg-violet-600 text-white rounded">1</button>
                            <button class="px-3 py-1 text-md border border-gray-200 rounded hover:bg-violet-50">Next</button>
                        </div>
                    </div>
                </div>


            </main>
        </div>
   </div>

   <!-- ADD TRAINER MODAL -->
   <div id="addModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
       <div class="bg-white rounded-lg shadow-xl w-full max-w-lg mx-4">
           <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
               <span class="font-medium text-lg">Add New Trainer</span>
               <button onclick="closeAddModal()" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
           </div>
           <form action="./actions/add_trainer.php" method="POST" class="px-6 py-4 flex flex-col gap-4">
               <div class="flex flex-col gap-1">
                   <label class="text-sm text-gray-500">Full Name</label>
                   <input type="text" name="full_name" class="border border-gray-200 rounded px-3 py-2 text-sm outline-none focus:border-violet-400" placeholder="Enter full name" required>
               </div>
               <div class="flex gap-4">
                   <div class="flex flex-col gap-1 flex-1">
                       <label class="text-sm text-gray-500">Email</label>
                       <input type="email" name="email" class="border border-gray-200 rounded px-3 py-2 text-sm outline-none focus:border-violet-400" placeholder="Enter email">
                   </div>
                   <div class="flex flex-col gap-1 flex-1">
                       <label class="text-sm text-gray-500">Phone</label>
                       <input type="text" name="phone" class="border border-gray-200 rounded px-3 py-2 text-sm outline-none focus:border-violet-400" placeholder="Enter phone">
                   </div>
               </div>
               <div class="flex gap-4">
                   <div class="flex flex-col gap-1 flex-1">
                       <label class="text-sm text-gray-500">Specialization</label>
                       <input type="text" name="specialization" class="border border-gray-200 rounded px-3 py-2 text-sm outline-none focus:border-violet-400" placeholder="e.g. CrossFit, Yoga">
                   </div>
                   <div class="flex flex-col gap-1 flex-1">
                       <label class="text-sm text-gray-500">Schedule</label>
                       <input type="text" name="schedule" class="border border-gray-200 rounded px-3 py-2 text-sm outline-none focus:border-violet-400" placeholder="e.g. Mon–Fri">
                   </div>
               </div>
               <div class="flex flex-col gap-1">
                   <label class="text-sm text-gray-500">Status</label>
                   <select name="status" class="border border-gray-200 rounded px-3 py-2 text-sm bg-white outline-none focus:border-violet-400">
                       <option value="active">Active</option>
                       <option value="leave">On Leave</option>
                   </select>
               </div>
               <div class="flex justify-end gap-3 pt-2">
                   <button type="button" onclick="closeAddModal()" class="px-4 py-2 text-sm border border-gray-200 rounded hover:bg-gray-50">Cancel</button>
                   <button type="submit" class="px-4 py-2 text-sm bg-violet-600 hover:bg-violet-700 text-white rounded">Save Trainer</button>
               </div>
           </form>
       </div>
   </div>

   <script>
       function openAddModal() { document.getElementById('addModal').classList.remove('hidden'); }
       function closeAddModal() { document.getElementById('addModal').classList.add('hidden'); }
   </script>
</body>
</html>
