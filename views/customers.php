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
    <title>Customers</title>
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
                <div class="text-2xl font-medium">Customers</div>
                <div class="flex items-center gap-4">
                    <span class="flex items-center justify-center rounded-full text-xl text-white font-bold p-3 bg-violet-500"><?= strtoupper($_SESSION['role'][0] . $_SESSION['role'][1]) ?></span>
                </div>
            </header>

            <main class="flex flex-col w-full px-6 mt-5 gap-6">

                <!-- KEY METRICS -->
                <div class="flex flex-col gap-2 w-full">
                    <div class="text-gray-500 font-medium">KEY METRICS</div>
                    <div class="flex gap-4 flex-wrap">
                        <div class="flex flex-1 flex-col justify-center gap-2 p-4 bg-white shadow-md rounded border-l-2 border-violet-600 w-full">
                            <span class="text-gray-400">Total Customers</span>
                            <div class="text-3xl font-bold" id="total_customer">0</div>
                            <span class="text-sm text-green-500">All registered members</span>
                        </div>
                        <div class="flex flex-1 flex-col justify-center gap-2 p-4 bg-white shadow-md rounded border-l-2 border-violet-600 w-full">
                            <span class="text-gray-400">Active Customers</span>
                            <div class="text-3xl font-bold" id="active_customer">0</div>
                            <span class="text-sm text-green-500">With active membership</span>
                        </div>
                        <div class="flex flex-1 flex-col justify-center gap-2 p-4 bg-white shadow-md rounded border-l-2 border-violet-600 w-full">
                            <span class="text-gray-400">New This Month</span>
                            <div class="text-3xl font-bold" id="new_customer">0</div>
                            <span class="text-sm text-green-500">Joined this month</span>
                        </div>
                    </div>
                </div>

                <!-- TOOLBAR -->
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-2 bg-white border border-gray-200 rounded px-4 py-2 w-full max-w-sm">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" placeholder="Search member name or ID..." class="outline-none text-md w-full" id="searchInput">
                    </div>
                    <div class="flex gap-3 items-center flex-wrap">
                        <select class="border border-gray-200 rounded px-3 py-2 text-md bg-white" id="statusFilter">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="expired">Expired</option>
                            <option value="expiring">Expiring Soon</option>
                        </select>
                        <select class="border border-gray-200 rounded px-3 py-2 text-md bg-white" id="planFilter">
                            <option value="">All Plans</option>
                            <option value="basic">Basic</option>
                            <option value="pro">Pro</option>
                            <option value="premium">Premium</option>
                        </select>
                        <button onclick="openAddModal()" class="flex items-center gap-2 bg-violet-600 hover:bg-violet-700 text-white px-4 py-2 rounded text-md font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Add Member
                        </button>
                    </div>
                </div>

                <!-- TABLE -->  
                <div class="bg-white shadow-md rounded overflow-auto">
                    <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
                        <span class="font-medium text-lg">Customer List</span>
                    </div>  
                    <table class="w-full text-md">
                        <thead class="text-gray-400 text-sm uppercase border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left">Name</th>
                                <th class="px-6 py-3 text-left">Type</th>  
                                <th class="px-6 py-3 text-left">Member</th>
                                <th class="px-6 py-3 text-left">Trainer</th>
                                <th class="px-6 py-3 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="membersTable" class="divide-y divide-gray-50">
                            <!-- Rows populated via PHP or JS -->
                            <tr>
                                <td class="px-6 py-3">Juan Dela Cruz</td>
                                <td class="px-6 py-3 ">Student</td>
                                <td class="px-6 py-3">Yes</td>
                                <td class="px-6 py-3">Carlo M.</td>
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
                                <td class="px-6 py-3">Charles Darwin</td>
                                <td class="px-6 py-3">Student</td>
                                <td class="px-6 py-3">No</td>
                                <td class="px-6 py-3">None</td>
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
                                <td class="px-6 py-3">Dwayne Wade</td>
                                <td class="px-6 py-3">Student</td>
                                <td class="px-6 py-3">Yes</td>
                                <td class="px-6 py-3">Carlo M.</td>
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
                                <td class="px-6 py-3">Jefferson Gabisan</td>
                                <td class="px-6 py-3">Student</td>
                                <td class="px-6 py-3">Yes</td>
                                <td class="px-6 py-3">Carlo M.</td>
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

   <!-- ADD MEMBER MODAL -->
   <div id="addModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
       <div class="bg-white rounded-lg shadow-xl w-full max-w-lg mx-4">
           <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
               <span class="font-medium text-lg">Add New Member</span>
               <button onclick="closeAddModal()" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
           </div>
           <form action="./actions/add_member.php" method="POST" class="px-6 py-4 flex flex-col gap-4">
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
                       <input type="text" name="phone" class="border border-gray-200 rounded px-3 py-2 text-sm outline-none focus:border-violet-400" placeholder="Enter phone number">
                   </div>
               </div>
               <div class="flex gap-4">
                   <div class="flex flex-col gap-1 flex-1">
                       <label class="text-sm text-gray-500">Membership Plan</label>
                       <select name="plan" class="border border-gray-200 rounded px-3 py-2 text-sm bg-white outline-none focus:border-violet-400">
                           <option value="basic">Basic</option>
                           <option value="pro">Pro</option>
                           <option value="premium">Premium</option>
                       </select>
                   </div>
                   <div class="flex flex-col gap-1 flex-1">
                       <label class="text-sm text-gray-500">Assign Trainer</label>
                       <select name="trainer_id" class="border border-gray-200 rounded px-3 py-2 text-sm bg-white outline-none focus:border-violet-400">
                           <option value="">No Trainer</option>
                           <!-- PHP: populate from DB -->
                       </select>
                   </div>
               </div>
               <div class="flex flex-col gap-1">
                   <label class="text-sm text-gray-500">Start Date</label>
                   <input type="date" name="start_date" class="border border-gray-200 rounded px-3 py-2 text-sm outline-none focus:border-violet-400">
               </div>
               <div class="flex justify-end gap-3 pt-2">
                   <button type="button" onclick="closeAddModal()" class="px-4 py-2 text-sm border border-gray-200 rounded hover:bg-gray-50">Cancel</button>
                   <button type="submit" class="px-4 py-2 text-sm bg-violet-600 hover:bg-violet-700 text-white rounded">Save Member</button>
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
