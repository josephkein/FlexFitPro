<?php
    session_start();
    if (!isset($_SESSION['role']) || $_SESSION['status'] != 'active') {
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
    <title>Memberships</title>
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
                        <span class="text-3xl font-medium">Memberships</span>
                        <span class="text-gray-500 text-lg">View active and expired memberships based on payment history.</span>
                </div>
                <!-- PLAN CARDS -->
                <div class="flex flex-col gap-3">
                    <div class="flex justify-between items-center">
                        <div class="text-gray-500 font-medium">MEMBERSHIP PLANS</div>
                        <button onclick="openAddModal()" class="flex items-center gap-2 bg-violet-600 hover:bg-violet-700 text-white px-4 py-2 rounded text-md font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            New Plan
                        </button>
                    </div>
                    <div class="flex gap-4 flex-wrap">

                        <!-- Basic Plan -->
                        <div class="flex flex-1 flex-col gap-4 bg-white shadow-md rounded p-6">
                            <div class="flex justify-between items-start">
                                <div>
                                    <div class="text-xl font-bold">Basic</div>
                                    <div class="text-sm text-gray-400">Monthly subscription</div>
                                </div>
                                <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-full">Basic</span>
                            </div>
                            <div class="flex items-baseline gap-1">
                                <span class="text-3xl font-bold text-violet-600">₱800</span>
                                <span class="text-gray-400 text-sm">/ month</span>
                            </div>
                            <div class="flex gap-4 w-full justify-end">
                                <a href="" class="text-blue-500 hover:text-blue-400">Edit</a>
                                <a href="" class="text-red-500 hover:text-red-400">Delete</a>
                            </div>
                        </div>
                        

                        <!-- Pro Plan (best seller) -->
                        <div class="flex flex-1 flex-col gap-4 bg-white shadow-md rounded p-6">
                            <div class="flex justify-between items-start">
                                <div>
                                    <div class="text-xl font-bold">Pro</div>
                                    <div class="text-sm text-gray-400">Quarterly subscription</div>
                                </div>
                                <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">Pro</span>
                            </div>
                            <div class="flex items-baseline gap-1">
                                <span class="text-3xl font-bold text-violet-600">₱2,300</span>
                                <span class="text-gray-400 text-sm">/ 3 months</span>
                            </div>
                            <div class="flex gap-4 w-full justify-end">
                                <a href="" class="text-blue-500 hover:text-blue-400">Edit</a>
                                <a href="" class="text-red-500 hover:text-red-400">Delete</a>
                            </div>
                        </div>

                        <!-- Premium Plan -->
                        <div class="flex flex-1 flex-col gap-4 bg-white shadow-md rounded p-6">
                            <div class="flex justify-between items-start">
                                <div>
                                    <div class="text-xl font-bold">Premium</div>
                                    <div class="text-sm text-gray-400">Annual subscription</div>
                                </div>
                                <span class="bg-violet-100 text-violet-700 text-xs px-2 py-1 rounded-full">Premium</span>
                            </div>
                            <div class="flex items-baseline gap-1">
                                <span class="text-3xl font-bold text-violet-600">₱8,500</span>
                                <span class="text-gray-400 text-sm">/ year</span>
                            </div>
                           <div class="flex gap-4 w-full justify-end">
                                <a href="" class="text-blue-500 hover:text-blue-400">Edit</a>
                                <a href="" class="text-red-500 hover:text-red-400">Delete</a>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- SUBSCRIBER TABLE -->
                <div class="bg-white shadow-md rounded overflow-auto max-h-150">
                    <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
                        <span class="font-medium text-lg">Members Breakdown</span>
                    </div>
                    <table class="w-full text-md">
                        <thead class="text-gray-400 text-xs uppercase border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left">Customer</th>
                                <th class="px-6 py-3 text-left">Plan</th>
                                <th class="px-6 py-3 text-left">Start Date</th>
                                <th class="px-6 py-3 text-left">Expiration Date</th>
                                <th class="px-6 py-3 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            <tr>
                                <td class="px-6 py-3">Jkeinskie</td>
                                <td class="px-6 py-3"><span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-full">Basic</span></td>
                                <td class="px-6 py-3">2026-01-20</td>
                                <td class="px-6 py-3">2026-02-20</td>
                                <td class="px-6 py-3"><span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">Active</span></td>
                            </tr>
                            <tr>
                                <td class="px-6 py-3">Jkeinskie</td>
                                <td class="px-6 py-3"><span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">Pro</span></td>
                                <td class="px-6 py-3">2026-01-20</td>
                                <td class="px-6 py-3">2026-02-20</td>
                                <td class="px-6 py-3"><span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">Active</span></td>
                            </tr>
                            <tr>
                                <td class="px-6 py-3">Jkeinskie</td>
                                <td class="px-6 py-3"><span class="bg-violet-100 text-violet-700 text-xs px-2 py-1 rounded-full">Premium</span></td>
                                <td class="px-6 py-3">2026-01-20</td>
                                <td class="px-6 py-3">2026-02-20</td>
                                <td class="px-6 py-3"><span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">Active</span></td>
                            </tr>
                             <tr>
                                <td class="px-6 py-3">Jkeinskie</td>
                                <td class="px-6 py-3"><span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-full">Basic</span></td>
                                <td class="px-6 py-3">2026-01-20</td>
                                <td class="px-6 py-3">2026-02-20</td>
                                <td class="px-6 py-3"><span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">Active</span></td>
                            </tr>
                            <tr>
                                <td class="px-6 py-3">Jkeinskie</td>
                                <td class="px-6 py-3"><span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">Pro</span></td>
                                <td class="px-6 py-3">2026-01-20</td>
                                <td class="px-6 py-3">2026-02-20</td>
                                <td class="px-6 py-3"><span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">Active</span></td>
                            </tr>
                            <tr>
                                <td class="px-6 py-3">Jkeinskie</td>
                                <td class="px-6 py-3"><span class="bg-violet-100 text-violet-700 text-xs px-2 py-1 rounded-full">Premium</span></td>
                                <td class="px-6 py-3">2026-01-20</td>
                                <td class="px-6 py-3">2026-02-20</td>
                                <td class="px-6 py-3"><span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">Active</span></td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>

            </main>
        </div>
   </div>

   <!-- ADD PLAN MODAL -->
   <div id="addModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
       <div class="bg-white rounded-lg shadow-xl w-full max-w-lg mx-4">
           <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
               <span class="font-medium text-lg">New Membership Plan</span>
               <button onclick="closeAddModal()" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
           </div>
           <form action="./actions/add_plan.php" method="POST" class="px-6 py-4 flex flex-col gap-4">
               <div class="flex flex-col gap-1">
                   <label class="text-sm text-gray-500">Plan Name</label>
                   <input type="text" name="plan_name" class="border border-gray-200 rounded px-3 py-2 text-sm outline-none focus:border-violet-400" placeholder="e.g. Pro, Premium" required>
               </div>
               <div class="flex gap-4">
                   <div class="flex flex-col gap-1 flex-1">
                       <label class="text-sm text-gray-500">Price (₱)</label>
                       <input type="number" name="price" class="border border-gray-200 rounded px-3 py-2 text-sm outline-none focus:border-violet-400" placeholder="0.00">
                   </div>
                   <div class="flex flex-col gap-1 flex-1">
                       <label class="text-sm text-gray-500">Duration</label>
                       <select name="duration" class="border border-gray-200 rounded px-3 py-2 text-sm bg-white outline-none focus:border-violet-400">
                           <option value="monthly">Monthly</option>
                           <option value="quarterly">Quarterly (3 months)</option>
                           <option value="annual">Annual (12 months)</option>
                       </select>
                   </div>
               </div>
               <div class="flex flex-col gap-1">
                   <label class="text-sm text-gray-500">Features (one per line)</label>
                   <textarea name="features" rows="4" class="border border-gray-200 rounded px-3 py-2 text-sm outline-none focus:border-violet-400" placeholder="24/7 gym access&#10;1 PT session/week&#10;Locker access"></textarea>
               </div>
               <div class="flex justify-end gap-3 pt-2">
                   <button type="button" onclick="closeAddModal()" class="px-4 py-2 text-sm border border-gray-200 rounded hover:bg-gray-50">Cancel</button>
                   <button type="submit" class="px-4 py-2 text-sm bg-violet-600 hover:bg-violet-700 text-white rounded">Save Plan</button>
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
