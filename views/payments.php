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
    <link rel="shortcut icon" href="./images/flexfit.png" type="image/x-icon">
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
            <?php include './views/header.php'?>

            <main class="flex flex-col w-full px-6 mt-5 gap-6">

                <div class="flex flex-col gap-1">
                        <span class="text-3xl font-medium">Payments</span>
                        <span class="text-gray-500 text-lg">Process visit and membership payments and track transactions.</span>
                </div>

                <!-- TOOLBAR -->
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-2 bg-white border border-gray-200 rounded px-4 py-2 w-full max-w-sm">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" placeholder="Search by name..." class="outline-none text-md w-full" id="searchInput">
                    </div>
                    <div class="flex gap-3 items-center flex-wrap">
                        <select class="border border-gray-200 rounded px-3 py-2 text-md bg-white" id="payment_type">
                            <option value="">All Type</option>
                            <option value="visit">Visit</option>
                            <option value="membership">Membership</option>
                        </select>
                        <input type="month" id="date" class="border border-gray-200 rounded px-3 py-2 text-md bg-white outline-none focus:border-violet-400">
                        <button onclick="openAddModal()" class="flex items-center gap-2 bg-violet-600 hover:bg-violet-700 text-white px-4 py-2 rounded text-md font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Record Payment
                        </button>
                    </div>
                </div>

                <!-- TABLE -->
                <div class="bg-white shadow-md rounded overflow-auto">
                    <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
                        <span class="font-medium text-lg">Payment Transactions</span>
                    </div>
                    <table class="w-full text-md">
                        <thead class="text-gray-400 text-md uppercase border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left">Date</th>
                                <th class="px-6 py-3 text-left">Customer</th>
                                <th class="px-6 py-3 text-left">Type</th>
                                <th class="px-6 py-3 text-left">Amount</th>
                                <th class="px-6 py-3 text-left">Staff</th>
                                <th class="px-6 py-3 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50" id="paymentTable">
                            <tr>
                                <td class="px-6 py-3">2026-01-01</td>
                                <td class="px-6 py-3">Juan Reyes</td>
                                <td class="px-6 py-3">Membership</td>
                                <td class="px-6 py-3 font-bold">₱800</td>
                                <td class="px-6 py-3">John Doe</td>
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
                    <div class="flex justify-center items-center px-6 py-4 border-t border-gray-100" id="pagination">
                        <div class="flex gap-2">
                            <button class="px-3 py-1 text-sm border border-gray-200 rounded hover:bg-violet-50" id="prev">Prev</button>
                            <button class="px-3 py-1 text-sm border border-violet-600 bg-violet-600 text-white rounded" id="page">1</button>
                            <button class="px-3 py-1 text-sm border border-gray-200 rounded hover:bg-violet-50" id="next">Next</button>
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
           <form id="payment_form" method="POST" class="px-6 py-4 flex flex-col gap-4">
               <div class="flex flex-col gap-1">
                   <label class="text-md text-gray-500">Customer ID</label>
                    <input type="number" name="customer_id" min="1" class="border border-gray-200 rounded px-3 py-2 text-md outline-none focus:border-violet-400" placeholder="e.g 1, 3, 15" required>
               </div>
               <div class="flex gap-4">
                   <div class="flex flex-col gap-1 flex-1">
                       <label class="text-md text-gray-500">Payment Type</label>
                       <select name="payment_type" class="border border-gray-200 rounded px-3 py-2 text-md bg-white outline-none focus:border-violet-400" required>
                           <option value="visit">Visit</option>
                           <option value="membership">Membership</option>
                       </select>
                   </div>
                   <div class="flex flex-col gap-1 flex-1">
                       <label class="text-md text-gray-500">Amount (₱)</label>
                       <input type="number" step="0.01" min="1" name="amount" class="border border-gray-200 rounded px-3 py-2 text-md outline-none focus:border-violet-400" placeholder="0.00" required>
                   </div>
               </div>
               <div class="flex justify-end gap-3 pt-2">
                   <button type="button" onclick="closeAddModal()" class="px-4 py-2 text-md border border-gray-200 rounded hover:bg-gray-50">Cancel</button>
                   <button type="submit" class="px-4 py-2 text-md bg-violet-600 hover:bg-violet-700 text-white rounded">Save Payment</button>
               </div>
           </form>
       </div>
   </div>

   <!-- UPDATE PAYMENT MODAL -->
   <div id="updatePayment" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
       <div class="bg-white rounded-lg shadow-xl w-full max-w-lg mx-4">
           <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
               <span class="font-medium text-lg">Record Payment</span>
               <button onclick="closeUpdate()" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
           </div>
           <form id="update-form" method="POST" class="px-6 py-4 flex flex-col gap-4">
               <div class="flex gap-4">
                   <div class="flex flex-col gap-1 flex-1">
                       <label class="text-md text-gray-500">Payment Type</label>
                       <select name="payment_type" id="up_type"  class="border border-gray-200 rounded px-3 py-2 text-md bg-white outline-none focus:border-violet-400" required>
                           <option value="visit">Visit</option>
                           <option value="membership">Membership</option>
                       </select>
                   </div>
                   <div class="flex flex-col gap-1 flex-1">
                       <label class="text-md text-gray-500">Amount (₱)</label>
                       <input type="number" step="0.01" min="1" id="up_amount"  name="amount" class="border border-gray-200 rounded px-3 py-2 text-md outline-none focus:border-violet-400" placeholder="0.00" required>
                   </div>
               </div>
               <div class="flex justify-end gap-3 pt-2">
                   <button type="button" onclick="closeUpdate()" class="px-4 py-2 text-md border border-gray-200 rounded hover:bg-gray-50">Cancel</button>
                   <button type="submit" class="px-4 py-2 text-md bg-violet-600 hover:bg-violet-700 text-white rounded">Save Payment</button>
               </div>
           </form>
       </div>
   </div>

   <script src="./assets/js/payments.js"></script>
</body>
</html>
