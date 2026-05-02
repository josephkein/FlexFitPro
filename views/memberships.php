<?php
    session_start();
    if (!isset($_SESSION['role']) || $_SESSION['status'] != 'active') {
        header('Location: ./index.php?url=login');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en" class="h-full min-h-0">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="shortcut icon" href="./images/flexfit.png" type="image/x-icon">
    <title>Memberships</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap');
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="h-full min-h-0 overflow-hidden">
   <div class="flex bg-gray-100 h-full w-full min-h-0">
    <!-- SIDE BAR -->
        <?php include './views/sidebar.php' ?>


        <!-- MAIN CONTENTS -->
        <div class="flex flex-col w-full h-screen overflow-auto pb-10">
            <?php include './views/header.php'?>

            <main class="flex flex-col w-full px-6 pt-5 gap-6">
                <div class="flex flex-col gap-1">
                        <span class="text-3xl font-medium">Memberships</span>
                        <span class="text-gray-500 text-lg">View active and expired memberships based on payment history.</span>
                </div>
                
                <!-- PLAN CARDS -->
                <div class="flex flex-col gap-3">
                    <div class="flex justify-between items-center">
                        <div class="text-gray-500 font-medium">MEMBERSHIP PLANS</div>
                        <?php if($_SESSION['role'] === 'admin'): ?>
                        <button onclick="openAddPlan()" class="flex items-center gap-2 bg-violet-600 hover:bg-violet-700 text-white px-4 py-2 rounded text-md font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            New Plan
                        </button>
                        <?php endif; ?>
                    </div>
                    <div class="flex gap-4 flex-wrap" id="plans">

                        

                    </div>
                </div>
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-2 bg-white border border-gray-200 rounded px-4 py-2 w-full max-w-sm">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" placeholder="Search member name..." class="outline-none text-md w-full" id="searchInput">
                    </div>
                    <div class="flex gap-3 items-center flex-wrap">
                        <select class="border border-gray-200 rounded px-3 py-2 text-md bg-white" id="planFilter">
                            <option value="">All Plan</option>
                            <option value="basic">Basic</option>
                            <option value="pro">Pro</option>
                            <option value="premium">Premium</option>
                        </select>
                        <select class="border border-gray-200 rounded px-3 py-2 text-md bg-white" id="statusFilter">
                            <option value="">Status</option>
                            <option value="active">Active</option>
                            <option value="expired">Expired</option>
                        </select>
                        <button onclick="openAddMember()" class="flex items-center gap-2 bg-violet-600 hover:bg-violet-700 text-white px-4 py-2 rounded text-md font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            New Member
                        </button>
                    </div>
                </div>
                <!-- SUBSCRIBER TABLE -->
                <div class="bg-white shadow-md rounded overflow-auto md:overflow-hidden">
                    <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
                        <span class="font-medium text-lg">Members Breakdown</span>
                    </div>  
                    <table class="w-full text-md">
                        <thead class="text-gray-400 text-md uppercase border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left">Customer</th>
                                <th class="px-6 py-3 text-left">Plan</th>
                                <th class="px-6 py-3 text-left">Start Date</th>  
                                <th class="px-6 py-3 text-left">End Date</th>
                                <th class="px-6 py-3 text-left">Status</th>
                                <?php if($_SESSION['role'] === 'admin'): ?>
                                    <th class="px-6 py-3 text-left">Action</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody id="membershipTable" class="divide-y divide-gray-50">
                            <!-- Rows populated via PHP or JS -->
                            
                            <!-- <tr>
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
                            </tr> -->
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
    <?php if($_SESSION['role'] === 'admin'): ?>
   <!-- ADD PLAN MODAL -->
   <div id="addPlan" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
       <div class="bg-white rounded-lg shadow-xl w-full max-w-lg mx-4">
           <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
               <span class="font-medium text-lg">New Membership Plan</span>
               <button onclick="closeAddPlan()" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
           </div>
           <form id="addPlanForm" method="POST" class="px-6 py-4 flex flex-col gap-4">
               <div class="flex flex-col gap-1">
                   <label class="text-sm text-gray-500">Plan Name</label>
                   <input type="text" name="plan_name" class="border border-gray-200 rounded px-3 py-2 text-sm outline-none focus:border-violet-400" placeholder="e.g. Pro, Premium" required>
               </div>
               <div class="flex gap-4">
                   <div class="flex flex-col gap-1 flex-1">
                       <label class="text-sm text-gray-500">Price (₱)</label>
                       <input type="number" name="price" step="0.01" min="0" class="border border-gray-200 rounded px-3 py-2 text-sm outline-none focus:border-violet-400" placeholder="0.00">
                   </div>
                   <div class="flex flex-col gap-1 flex-1">
                       <label class="text-sm text-gray-500">Duration</label>
                        <input type="number" name="duration" step="1" min="1" class="border border-gray-200 rounded px-3 py-2 text-sm outline-none focus:border-violet-400" placeholder="1">
                   </div>
               </div>
               <div class="flex justify-end gap-3 pt-2">
                   <button type="button" onclick="closeAddPlan()" class="px-4 py-2 text-sm border border-gray-200 rounded hover:bg-gray-50">Cancel</button>
                   <button type="submit" class="px-4 py-2 text-sm bg-violet-600 hover:bg-violet-700 text-white rounded">Save Plan</button>
               </div>
           </form>
       </div>
   </div>


   <!-- UPDATE PLAN -->
   <div id="updatePlanModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
       <div class="bg-white rounded-lg shadow-xl w-full max-w-lg mx-4">
           <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
               <span class="font-medium text-lg">Update Membership Plan</span>
               <button onclick="closeUpdatePlanModal()" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
           </div>
           <form id="updatePlanForm" method="POST" class="px-6 py-4 flex flex-col gap-4">
            <input type="hidden" name="planId" id="planId">
               <div class="flex flex-col gap-1">
                   <label class="text-sm text-gray-500">Plan Name</label>
                   <input type="text" name="update_plan" id="update_plan" class="border border-gray-200 rounded px-3 py-2 text-sm outline-none focus:border-violet-400" placeholder="e.g. Pro, Premium" required>
               </div>
               <div class="flex gap-4">
                   <div class="flex flex-col gap-1 flex-1">
                       <label class="text-sm text-gray-500">Price (₱)</label>
                       <input type="number" name="update_price" id="update_price" step="0.01" min="1" class="border border-gray-200 rounded px-3 py-2 text-sm outline-none focus:border-violet-400" placeholder="0.00">
                   </div>
                   <div class="flex flex-col gap-1 flex-1">
                       <label class="text-sm text-gray-500">Duration</label>
                        <input type="number" name="update_duration" id="update_duration" step="1" min="1" class="border border-gray-200 rounded px-3 py-2 text-sm outline-none focus:border-violet-400" placeholder="1">

                   </div>
               </div>
               <div class="flex justify-end gap-3 pt-2">
                   <button type="button" onclick="closeUpdatePlanModal()" class="px-4 py-2 text-sm border border-gray-200 rounded hover:bg-gray-50">Cancel</button>
                   <button type="submit" class="px-4 py-2 text-sm bg-violet-600 hover:bg-violet-700 text-white rounded">Save Plan</button>
               </div>
           </form>
       </div>
   </div>
    <?php endif; ?>
    <script>
       window.isAdmin = <?= isset($_SESSION['role']) && $_SESSION['role'] === 'admin' ? 'true' : 'false' ?>;
   </script>
   <script src="./assets/js/membership.js">
   </script>
</body>
</html>
