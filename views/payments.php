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
    <title>Payments</title>
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
                <div class="text-2xl font-medium">Payments</div>
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
                            <span class="text-gray-400">Monthly Revenue</span>
                            <div class="text-3xl font-bold" id="monthly_revenue">₱0</div>
                            <span class="text-sm text-green-500">This month</span>
                        </div>
                        <div class="flex flex-1 flex-col justify-center gap-2 p-4 bg-white shadow-md rounded border-l-2 border-violet-600">
                            <span class="text-gray-400">Collected Today</span>
                            <div class="text-3xl font-bold" id="collected_today">₱0</div>
                            <span class="text-sm text-green-500">0 transactions</span>
                        </div>
                        <div class="flex flex-1 flex-col justify-center gap-2 p-4 bg-white shadow-md rounded border-l-2 border-violet-600">
                            <span class="text-gray-400">Pending</span>
                            <div class="text-3xl font-bold" id="pending_amount">₱0</div>
                            <span class="text-sm text-yellow-500">0 invoices</span>
                        </div>
                        <div class="flex flex-1 flex-col justify-center gap-2 p-4 bg-white shadow-md rounded border-l-2 border-violet-600">
                            <span class="text-gray-400">Failed</span>
                            <div class="text-3xl font-bold" id="failed_amount">₱0</div>
                            <span class="text-sm text-red-500">0 transactions</span>
                        </div>
                    </div>
                </div>

                <!-- TOOLBAR -->
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-2 bg-white border border-gray-200 rounded px-4 py-2 w-full max-w-sm">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" placeholder="Search by name or transaction ID..." class="outline-none text-sm w-full">
                    </div>
                    <div class="flex gap-3 items-center flex-wrap">
                        <select class="border border-gray-200 rounded px-3 py-2 text-sm bg-white">
                            <option value="">All Status</option>
                            <option value="paid">Paid</option>
                            <option value="pending">Pending</option>
                            <option value="failed">Failed</option>
                        </select>
                        <select class="border border-gray-200 rounded px-3 py-2 text-sm bg-white">
                            <option value="">All Methods</option>
                            <option value="cash">Cash</option>
                            <option value="gcash">GCash</option>
                            <option value="maya">Maya</option>
                            <option value="card">Credit Card</option>
                        </select>
                        <input type="month" value="<?= date('Y-m') ?>" class="border border-gray-200 rounded px-3 py-2 text-sm bg-white outline-none focus:border-violet-400">
                        <button onclick="openAddModal()" class="flex items-center gap-2 bg-violet-600 hover:bg-violet-700 text-white px-4 py-2 rounded text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Record Payment
                        </button>
                    </div>
                </div>

                <!-- TABLE -->
                <div class="bg-white shadow-md rounded overflow-auto">
                    <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
                        <span class="font-medium">Payment Transactions</span>
                        <span class="text-sm text-gray-400"><?= date('F Y') ?></span>
                    </div>
                    <table class="w-full text-sm">
                        <thead class="text-gray-400 text-xs uppercase border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left">Member</th>
                                <th class="px-6 py-3 text-left">Transaction ID</th>
                                <th class="px-6 py-3 text-left">Plan</th>
                                <th class="px-6 py-3 text-left">Amount</th>
                                <th class="px-6 py-3 text-left">Method</th>
                                <th class="px-6 py-3 text-left">Date</th>
                                <th class="px-6 py-3 text-left">Status</th>
                                <th class="px-6 py-3 text-left">Actions</th>
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
                                <td class="px-6 py-3 text-gray-400 text-xs">TXN-20250412-001</td>
                                <td class="px-6 py-3">Premium Annual</td>
                                <td class="px-6 py-3 font-bold">₱5,800</td>
                                <td class="px-6 py-3">GCash</td>
                                <td class="px-6 py-3">Apr 12, 2025</td>
                                <td class="px-6 py-3"><span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">Paid</span></td>
                                <td class="px-6 py-3">
                                    <div class="flex gap-2">
                                        <button class="text-violet-600 hover:underline text-xs">View</button>
                                        <button class="text-blue-600 hover:underline text-xs">Edit</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-2">
                                        <span class="w-8 h-8 rounded-full bg-yellow-500 text-white flex items-center justify-center text-xs font-bold">AL</span>
                                        Angelo Lim
                                    </div>
                                </td>
                                <td class="px-6 py-3 text-gray-400 text-xs">TXN-20250411-009</td>
                                <td class="px-6 py-3">Quarterly Pro</td>
                                <td class="px-6 py-3 font-bold">₱3,500</td>
                                <td class="px-6 py-3">Credit Card</td>
                                <td class="px-6 py-3">Apr 11, 2025</td>
                                <td class="px-6 py-3"><span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded-full">Pending</span></td>
                                <td class="px-6 py-3">
                                    <div class="flex gap-2">
                                        <button class="text-violet-600 hover:underline text-xs">View</button>
                                        <button class="text-blue-600 hover:underline text-xs">Edit</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-2">
                                        <span class="w-8 h-8 rounded-full bg-red-400 text-white flex items-center justify-center text-xs font-bold">KD</span>
                                        Karl Dela Cruz
                                    </div>
                                </td>
                                <td class="px-6 py-3 text-gray-400 text-xs">TXN-20250410-005</td>
                                <td class="px-6 py-3">Premium Annual</td>
                                <td class="px-6 py-3 font-bold">₱5,800</td>
                                <td class="px-6 py-3">Credit Card</td>
                                <td class="px-6 py-3">Apr 10, 2025</td>
                                <td class="px-6 py-3"><span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded-full">Failed</span></td>
                                <td class="px-6 py-3">
                                    <div class="flex gap-2">
                                        <button class="text-violet-600 hover:underline text-xs">View</button>
                                        <button class="text-blue-600 hover:underline text-xs">Edit</button>
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

   <!-- RECORD PAYMENT MODAL -->
   <div id="addModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
       <div class="bg-white rounded-lg shadow-xl w-full max-w-lg mx-4">
           <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
               <span class="font-medium text-lg">Record Payment</span>
               <button onclick="closeAddModal()" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
           </div>
           <form action="./actions/add_payment.php" method="POST" class="px-6 py-4 flex flex-col gap-4">
               <div class="flex flex-col gap-1">
                   <label class="text-sm text-gray-500">Member</label>
                   <select name="member_id" class="border border-gray-200 rounded px-3 py-2 text-sm bg-white outline-none focus:border-violet-400">
                       <option value="">Select member...</option>
                       <!-- PHP: populate from DB -->
                   </select>
               </div>
               <div class="flex gap-4">
                   <div class="flex flex-col gap-1 flex-1">
                       <label class="text-sm text-gray-500">Plan</label>
                       <select name="plan" class="border border-gray-200 rounded px-3 py-2 text-sm bg-white outline-none focus:border-violet-400">
                           <option value="basic">Basic — ₱1,200</option>
                           <option value="pro">Pro — ₱3,500</option>
                           <option value="premium">Premium — ₱5,800</option>
                       </select>
                   </div>
                   <div class="flex flex-col gap-1 flex-1">
                       <label class="text-sm text-gray-500">Amount (₱)</label>
                       <input type="number" name="amount" class="border border-gray-200 rounded px-3 py-2 text-sm outline-none focus:border-violet-400" placeholder="0.00">
                   </div>
               </div>
               <div class="flex gap-4">
                   <div class="flex flex-col gap-1 flex-1">
                       <label class="text-sm text-gray-500">Payment Method</label>
                       <select name="method" class="border border-gray-200 rounded px-3 py-2 text-sm bg-white outline-none focus:border-violet-400">
                           <option value="cash">Cash</option>
                           <option value="gcash">GCash</option>
                           <option value="maya">Maya</option>
                           <option value="card">Credit Card</option>
                       </select>
                   </div>
                   <div class="flex flex-col gap-1 flex-1">
                       <label class="text-sm text-gray-500">Status</label>
                       <select name="status" class="border border-gray-200 rounded px-3 py-2 text-sm bg-white outline-none focus:border-violet-400">
                           <option value="paid">Paid</option>
                           <option value="pending">Pending</option>
                       </select>
                   </div>
               </div>
               <div class="flex flex-col gap-1">
                   <label class="text-sm text-gray-500">Date</label>
                   <input type="date" name="date" value="<?= date('Y-m-d') ?>" class="border border-gray-200 rounded px-3 py-2 text-sm outline-none focus:border-violet-400">
               </div>
               <div class="flex justify-end gap-3 pt-2">
                   <button type="button" onclick="closeAddModal()" class="px-4 py-2 text-sm border border-gray-200 rounded hover:bg-gray-50">Cancel</button>
                   <button type="submit" class="px-4 py-2 text-sm bg-violet-600 hover:bg-violet-700 text-white rounded">Save Payment</button>
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
