<?php
    session_start();
    if (!isset($_SESSION['role']) || $_SESSION['status'] != 'active' || $_SESSION['role'] != 'admin') {
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
    <link rel="shortcut icon" href="./images/flexfit.png" type="image/x-icon">
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
            <?php include './views/header.php'?>
            <main class="flex flex-col w-full px-6 mt-5 gap-6">

                <div class="flex flex-col gap-1">
                        <span class="text-3xl font-medium">Staff Accounts</span>
                        <span class="text-gray-500 text-lg">Create and manage system users with role-based access.</span>
                </div>
                <!-- TOOLBAR -->
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-2 bg-white border border-gray-200 rounded px-4 py-2 w-full max-w-sm">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" id="searchInput" placeholder="Search staff account..." class="outline-none text-md w-full">
                    </div>
                    <div class="flex gap-3 items-center flex-wrap">
                        <select id="role" class="border border-gray-200 rounded px-3 py-2 text-md bg-white">
                            <option value="">All Roles</option>
                            <option value="admin">Admin</option>
                            <option value="staff">Staff</option>
                        </select>
                        <select id="status" class="border border-gray-200 rounded px-3 py-2 text-md bg-white">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="disabled">Disabled</option>
                        </select>
                        <button onclick="openAddModal()" class="flex items-center gap-2 bg-violet-700 hover:bg-violet-800 text-white px-4 py-2 rounded text-md font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Add Account
                        </button>
                    </div>
                </div>

                <!-- TABLE -->
                <div class="bg-white shadow-md rounded overflow-auto">
                    <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
                        <span class="font-medium text-xl">Accounts List</span>
                    </div>
                    <table class="w-full text-md">
                        <thead class="text-gray-400 text-md uppercase border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left">Username</th>
                                <th class="px-6 py-3 text-left">Role</th>
                                <th class="px-6 py-3 text-left">Status</th>
                                <th class="px-6 py-3 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="staffTable" class="divide-y divide-gray-50">
                            
                           
                        </tbody>
                    </table>
                    <div id="pagination" class="flex justify-center items-center px-6 py-4 border-t border-gray-100">
                        <div class="flex gap-2">
                            <button class="px-3 py-1 text-md border border-gray-200 rounded hover:bg-violet-50" id="prev">Prev</button>
                            <button class="px-3 py-1 text-md border border-violet-800 bg-violet-800 text-white rounded" id="page">1</button>
                            <button class="px-3 py-1 text-md border border-gray-200 rounded hover:bg-violet-50" id="next">Next</button>
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
           <form method="POST" id="accForm" class="px-6 py-4 flex flex-col gap-4">
               <div class="flex flex-col gap-1">
                   <label class="text-md text-gray-500">Username</label>
                   <input type="text" name="username" class="border border-gray-200 rounded px-3 py-2 text-md outline-none focus:border-violet-600" placeholder="Enter username" required>
               </div>
               <div class="flex gap-4">
                   <div class="flex flex-col gap-1 flex-1">
                       <label class="text-md text-gray-500">Role</label>
                       <select name="role" class="border border-gray-200 rounded px-3 py-2 text-md bg-white outline-none focus:border-violet-600">
                           <option value="admin">Admin</option>
                           <option value="staff">Staff</option>
                       </select>
                   </div>
                   <div class="flex flex-col gap-1 flex-1">
                       <label class="text-md text-gray-500">Status</label>
                       <select name="status" class="border border-gray-200 rounded px-3 py-2 text-md bg-white outline-none focus:border-violet-600">
                           <option value="active">Active</option>
                           <option value="disabled">Disabled</option>
                       </select>
                   </div>
               </div>
               <div class="flex flex-col gap-1">
                   <label class="text-md text-gray-500">Password</label>
                   <input type="password" name="password" class="border border-gray-200 rounded px-3 py-2 text-md outline-none focus:border-violet-600" placeholder="Set initial password" required>
               </div>
               <div class="flex flex-col gap-1">
                   <label class="text-md text-gray-500">Confirm Password</label>
                   <input type="password" name="confirm_password" class="border border-gray-200 rounded px-3 py-2 text-md outline-none focus:border-violet-600" placeholder="Repeat password" required>
               </div>
               <div class="flex justify-end gap-3 pt-2">
                   <button type="button" onclick="closeAddModal()" class="px-4 py-2 text-md border border-gray-200 rounded hover:bg-gray-50">Cancel</button>
                   <button type="submit" class="px-4 py-2 text-md bg-violet-700 hover:bg-violet-800 text-white rounded">Create Account</button>
               </div>
           </form>
       </div>
   </div>

    <!-- UPDATE -->
    <div id="updateModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
       <div class="bg-white rounded-lg shadow-xl w-full max-w-lg mx-4">
           <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
               <span class="font-medium text-lg">Update Staff Account</span>
               <button onclick="closeUpdateModal()" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
           </div>
           <form method="POST" id="updateForm" class="px-6 py-4 flex flex-col gap-4">
            <input type="hidden" name="acc_id" id="acc_id"> 
               <div class="flex flex-col gap-1">
                   <label class="text-md text-gray-500">Username</label>
                   <input type="text" name="update_username" id="update_username" class="border border-gray-200 rounded px-3 py-2 text-md outline-none focus:border-violet-600" placeholder="Enter username" required>
               </div>
               <div class="flex gap-4">
                   <div class="flex flex-col gap-1 flex-1">
                       <label class="text-md text-gray-500">Role</label>
                       <select name="update_role" id="update_role" class="border border-gray-200 rounded px-3 py-2 text-md bg-white outline-none focus:border-violet-600">
                           <option value="admin">Admin</option>
                           <option value="staff">Staff</option>
                       </select>
                   </div>
                   <div class="flex flex-col gap-1 flex-1">
                       <label class="text-md text-gray-500">Status</label>
                       <select name="update_status" id="update_status" class="border border-gray-200 rounded px-3 py-2 text-md bg-white outline-none focus:border-violet-600">
                           <option value="active">Active</option>
                           <option value="disabled">Disabled</option>
                       </select>
                   </div>
               </div>
               <div class="flex flex-col gap-1">
                   <label class="text-md text-gray-500">New Password (Optional)</label>
                   <input type="password" name="update_password" id="update_password" class="border border-gray-200 rounded px-3 py-2 text-md outline-none focus:border-violet-600" placeholder="Set new password">
               </div>
               <div class="flex justify-end gap-3 pt-2">
                   <button type="button" onclick="closeUpdateModal()" class="px-4 py-2 text-md border border-gray-200 rounded hover:bg-gray-50">Cancel</button>
                   <button type="submit" class="px-4 py-2 text-md bg-violet-700 hover:bg-violet-800 text-white rounded">Update Account</button>
               </div>
           </form>
       </div>
   </div>

   <script src="./assets/js/staff.js">
   </script>
</body>
</html>
