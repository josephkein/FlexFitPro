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
    <title>Staff Accounts</title>
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
                <div class="text-2xl font-medium">Staff Accounts</div>
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
                            <span class="text-gray-400">Total Staff</span>
                            <div class="text-3xl font-bold" id="total_staff">0</div>
                            <span class="text-sm text-gray-400">All accounts</span>
                        </div>
                        <div class="flex flex-1 flex-col justify-center gap-2 p-4 bg-white shadow-md rounded border-l-2 border-violet-600">
                            <span class="text-gray-400">Admins</span>
                            <div class="text-3xl font-bold" id="total_admins">0</div>
                            <span class="text-sm text-violet-500">Full access</span>
                        </div>
                        <div class="flex flex-1 flex-col justify-center gap-2 p-4 bg-white shadow-md rounded border-l-2 border-violet-600">
                            <span class="text-gray-400">Front Desk</span>
                            <div class="text-3xl font-bold" id="total_frontdesk">0</div>
                            <span class="text-sm text-gray-400">Limited access</span>
                        </div>
                        <div class="flex flex-1 flex-col justify-center gap-2 p-4 bg-white shadow-md rounded border-l-2 border-violet-600">
                            <span class="text-gray-400">Trainers</span>
                            <div class="text-3xl font-bold" id="total_trainer_acc">0</div>
                            <span class="text-sm text-gray-400">Trainer access</span>
                        </div>
                    </div>
                </div>

                <!-- TOOLBAR -->
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-2 bg-white border border-gray-200 rounded px-4 py-2 w-full max-w-sm">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" placeholder="Search staff account..." class="outline-none text-sm w-full">
                    </div>
                    <div class="flex gap-3 items-center flex-wrap">
                        <select class="border border-gray-200 rounded px-3 py-2 text-sm bg-white">
                            <option value="">All Roles</option>
                            <option value="admin">Admin</option>
                            <option value="frontdesk">Front Desk</option>
                            <option value="trainer">Trainer</option>
                        </select>
                        <select class="border border-gray-200 rounded px-3 py-2 text-sm bg-white">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="disabled">Disabled</option>
                        </select>
                        <button onclick="openAddModal()" class="flex items-center gap-2 bg-violet-600 hover:bg-violet-700 text-white px-4 py-2 rounded text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Add Account
                        </button>
                    </div>
                </div>

                <!-- TABLE -->
                <div class="bg-white shadow-md rounded overflow-auto">
                    <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
                        <span class="font-medium">Staff Accounts</span>
                        <span class="text-sm text-gray-400">0 accounts</span>
                    </div>
                    <table class="w-full text-sm">
                        <thead class="text-gray-400 text-xs uppercase border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left">Name</th>
                                <th class="px-6 py-3 text-left">Email</th>
                                <th class="px-6 py-3 text-left">Role</th>
                                <th class="px-6 py-3 text-left">Last Login</th>
                                <th class="px-6 py-3 text-left">Status</th>
                                <th class="px-6 py-3 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            <tr>
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-2">
                                        <span class="w-8 h-8 rounded-full bg-violet-600 text-white flex items-center justify-center text-xs font-bold">AD</span>
                                        Admin User
                                    </div>
                                </td>
                                <td class="px-6 py-3 text-gray-400 text-xs">admin@flexfitpro.com</td>
                                <td class="px-6 py-3"><span class="bg-violet-100 text-violet-700 text-xs px-2 py-1 rounded-full">Admin</span></td>
                                <td class="px-6 py-3 text-gray-500">Today 6:02 AM</td>
                                <td class="px-6 py-3"><span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">Active</span></td>
                                <td class="px-6 py-3">
                                    <div class="flex gap-2">
                                        <button class="text-blue-600 hover:underline text-xs">Edit</button>
                                        <button class="text-yellow-600 hover:underline text-xs">Disable</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-2">
                                        <span class="w-8 h-8 rounded-full bg-teal-500 text-white flex items-center justify-center text-xs font-bold">LD</span>
                                        Liza Domingo
                                    </div>
                                </td>
                                <td class="px-6 py-3 text-gray-400 text-xs">liza@flexfitpro.com</td>
                                <td class="px-6 py-3"><span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-full">Front Desk</span></td>
                                <td class="px-6 py-3 text-gray-500">Today 7:15 AM</td>
                                <td class="px-6 py-3"><span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">Active</span></td>
                                <td class="px-6 py-3">
                                    <div class="flex gap-2">
                                        <button class="text-blue-600 hover:underline text-xs">Edit</button>
                                        <button class="text-yellow-600 hover:underline text-xs">Disable</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-2">
                                        <span class="w-8 h-8 rounded-full bg-yellow-500 text-white flex items-center justify-center text-xs font-bold">CM</span>
                                        Carlo Mendoza
                                    </div>
                                </td>
                                <td class="px-6 py-3 text-gray-400 text-xs">carlo@flexfitpro.com</td>
                                <td class="px-6 py-3"><span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded-full">Trainer</span></td>
                                <td class="px-6 py-3 text-gray-500">Today 5:45 AM</td>
                                <td class="px-6 py-3"><span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">Active</span></td>
                                <td class="px-6 py-3">
                                    <div class="flex gap-2">
                                        <button class="text-blue-600 hover:underline text-xs">Edit</button>
                                        <button class="text-yellow-600 hover:underline text-xs">Disable</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-2">
                                        <span class="w-8 h-8 rounded-full bg-gray-400 text-white flex items-center justify-center text-xs font-bold">MB</span>
                                        Mark Bautista
                                    </div>
                                </td>
                                <td class="px-6 py-3 text-gray-400 text-xs">mark@flexfitpro.com</td>
                                <td class="px-6 py-3"><span class="bg-violet-100 text-violet-700 text-xs px-2 py-1 rounded-full">Admin</span></td>
                                <td class="px-6 py-3 text-gray-500">Apr 11, 2025</td>
                                <td class="px-6 py-3"><span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded-full">Disabled</span></td>
                                <td class="px-6 py-3">
                                    <div class="flex gap-2">
                                        <button class="text-blue-600 hover:underline text-xs">Edit</button>
                                        <button class="text-green-600 hover:underline text-xs">Enable</button>
                                        <button class="text-red-500 hover:underline text-xs">Delete</button>
                                    </div>
                                </td>
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

   <!-- ADD ACCOUNT MODAL -->
   <div id="addModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
       <div class="bg-white rounded-lg shadow-xl w-full max-w-lg mx-4">
           <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
               <span class="font-medium text-lg">Add Staff Account</span>
               <button onclick="closeAddModal()" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
           </div>
           <form action="./actions/add_staff.php" method="POST" class="px-6 py-4 flex flex-col gap-4">
               <div class="flex flex-col gap-1">
                   <label class="text-sm text-gray-500">Full Name</label>
                   <input type="text" name="full_name" class="border border-gray-200 rounded px-3 py-2 text-sm outline-none focus:border-violet-400" placeholder="Enter full name" required>
               </div>
               <div class="flex flex-col gap-1">
                   <label class="text-sm text-gray-500">Email Address</label>
                   <input type="email" name="email" class="border border-gray-200 rounded px-3 py-2 text-sm outline-none focus:border-violet-400" placeholder="Enter email" required>
               </div>
               <div class="flex gap-4">
                   <div class="flex flex-col gap-1 flex-1">
                       <label class="text-sm text-gray-500">Role</label>
                       <select name="role" class="border border-gray-200 rounded px-3 py-2 text-sm bg-white outline-none focus:border-violet-400">
                           <option value="admin">Admin</option>
                           <option value="frontdesk">Front Desk</option>
                           <option value="trainer">Trainer</option>
                       </select>
                   </div>
                   <div class="flex flex-col gap-1 flex-1">
                       <label class="text-sm text-gray-500">Status</label>
                       <select name="status" class="border border-gray-200 rounded px-3 py-2 text-sm bg-white outline-none focus:border-violet-400">
                           <option value="active">Active</option>
                           <option value="disabled">Disabled</option>
                       </select>
                   </div>
               </div>
               <div class="flex flex-col gap-1">
                   <label class="text-sm text-gray-500">Password</label>
                   <input type="password" name="password" class="border border-gray-200 rounded px-3 py-2 text-sm outline-none focus:border-violet-400" placeholder="Set initial password" required>
               </div>
               <div class="flex flex-col gap-1">
                   <label class="text-sm text-gray-500">Confirm Password</label>
                   <input type="password" name="confirm_password" class="border border-gray-200 rounded px-3 py-2 text-sm outline-none focus:border-violet-400" placeholder="Repeat password" required>
               </div>
               <div class="flex justify-end gap-3 pt-2">
                   <button type="button" onclick="closeAddModal()" class="px-4 py-2 text-sm border border-gray-200 rounded hover:bg-gray-50">Cancel</button>
                   <button type="submit" class="px-4 py-2 text-sm bg-violet-600 hover:bg-violet-700 text-white rounded">Create Account</button>
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
