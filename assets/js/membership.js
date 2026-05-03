let page = 1;

const next = document.getElementById('next');
const prev = document.getElementById('prev');
// Pagination
next.addEventListener('click', (e) => {
    e.preventDefault();
    let plan = document.getElementById('planFilter');
    let search = document.getElementById('searchInput');

    page++;
    fetch(`./api/membership/display.php?page=${page}&plan=${plan.value}&search=${search.value}`)
    .then(res => res.json())
    .then(data => {
        document.getElementById('page').textContent = page;
        renderData(data);
    })
})

prev.addEventListener('click', (e) => {
    e.preventDefault();
    let plan = document.getElementById('planFilter');
    let search = document.getElementById('searchInput');

    page--;
    fetch(`./api/membership/display.php?page=${page}&plan=${plan.value}&search=${search.value}`)
    .then(res => res.json())
    .then(data => {
        document.getElementById('page').textContent = page;
        renderData(data);
    })
})

function loadPlans(){

    fetch('./api/plans/display.php')
    .then(res => res.json())
    .then(data => {
        renderPlans(data);

    })
}

loadPlans();

function renderPlans(plans){
    document.getElementById('plans').innerHTML = '';


    plans.forEach(p => {
        let bg = p.name == 'Basic' ? 'text-blue-700 bg-blue-100' : p.name == 'Pro' ? 'text-green-700 bg-green-100' : 'text-violet-700 bg-violet-100';
        document.getElementById('plans').innerHTML += `
            <div class="flex flex-1 flex-col gap-4 bg-white shadow-md rounded p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="text-xl font-bold">${p.name} </div>
                        <div class="text-sm text-gray-400">${p.name} subscription</div>
                    </div>
                        <span class="${bg} text-xs px-2 py-1 rounded-full">${p.name}</span>
                </div>
                <div class="flex items-baseline gap-1">
                    <span class="text-3xl font-bold text-violet-600">₱${Number(p.price).toLocaleString()}</span>
                    <span class="text-gray-400 text-sm">/ ${p.duration == 1 ? p.duration + ' month' : p.duration + ' months'}</span>      
                </div>
                ${window.isAdmin ? `
                <div class="flex gap-4 w-full justify-end">
                    <a class="text-blue-500 hover:text-blue-400 cursor-pointer" onclick="editPlan(${p.id})">Edit</a>
                    <a class="text-red-500 hover:text-red-400 cursor-pointer" onclick="deletePlan(${p.id})">Delete</a>
                </div>
                ` : ''}
            </div>
        `;  
    });

    populateMembershipPlanSelect(plans);
    populatePlanFilter(plans);
}

function populateMembershipPlanSelect(plans) {
    const planSelect = document.getElementById('membershipPlanSelect');
    if (!planSelect) return;

    planSelect.innerHTML = '<option value="">Select plan</option>';
    plans.forEach(p => {
        const option = document.createElement('option');
        option.value = p.id;
        option.dataset.price = p.price;
        option.dataset.name = p.name;
        option.textContent = `${p.name} - ₱${Number(p.price).toLocaleString()} (${p.duration == 1 ? p.duration + ' mo' : p.duration + ' mos'})`;
        planSelect.appendChild(option);
    });
}

function populatePlanFilter(plans) {
    const filterSelect = document.getElementById('planFilter');
    if (!filterSelect) return;

    filterSelect.innerHTML = '<option value="">All Plan</option>';
    plans.forEach(p => {
        const option = document.createElement('option');
        option.value = p.name;
        option.textContent = p.name;
        filterSelect.appendChild(option);
    });
}

function showModal(modal){
    if (!modal) return;
    modal.classList.remove('hidden', 'opacity-0');
    modal.classList.add('flex', 'opacity-100');
}

function hideModal(modal){
    if (!modal) return;
    modal.classList.remove('opacity-100');
    modal.classList.add('opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 200);
}

function openAddPlan(){
    document.getElementById('addPlan').classList.remove('hidden');
}

function closeAddPlan(){
    document.getElementById('addPlan').classList.add('hidden');
}

function openUpdatePlanModal(){
    document.getElementById('updatePlanModal').classList.remove('hidden');
}

function closeUpdatePlanModal(){
    document.getElementById('updatePlanModal').classList.add('hidden');
}

function openUpdateMembershipModal(){
    showModal(document.getElementById('updateMembershipModal'));
}

function closeUpdateMembershipModal(){
    hideModal(document.getElementById('updateMembershipModal'));
}

function openAddMembership(){
    showModal(document.getElementById('addMembershipModal'));
}

function closeAddMembership(){
    hideModal(document.getElementById('addMembershipModal'));
    resetAddMembershipForm();
}

function resetAddMembershipForm(){
    const form = document.getElementById('addMembershipForm');
    if (!form) return;
    form.reset();
    document.getElementById('customerId').value = '';
    hideMembershipCustomerSuggestions();
}

function openPaymentModal(){
    showModal(document.getElementById('paymentModal'));
}

function closePaymentModal(){
    hideModal(document.getElementById('paymentModal'));
    showModal(document.getElementById('addMembershipModal'));
}

const membershipCustomerSearch = document.getElementById('customerSearchInput');
const membershipCustomerSuggestions = document.getElementById('customerSuggestions');
const paymentModal = document.getElementById('paymentModal');
const paymentModalForm = document.getElementById('paymentModalForm');
const paymentPlanName = document.getElementById('paymentPlanName');
const paymentAmountDisplay = document.getElementById('paymentAmountDisplay');
const paymentCashInput = document.getElementById('paymentCashInput');
const paymentChangeDisplay = document.getElementById('paymentChangeDisplay');
const paymentErrorText = document.getElementById('paymentErrorText');
const paymentCustomerIdHidden = document.getElementById('paymentCustomerId');
const paymentPlanIdHidden = document.getElementById('paymentPlanId');
const paymentAmountHidden = document.getElementById('paymentAmount');
const paymentStartDateHidden = document.getElementById('paymentStartDate');
let membershipCustomerTimer;

if (membershipCustomerSearch && membershipCustomerSuggestions) {
    membershipCustomerSearch.addEventListener('input', (event) => {
        const searchValue = event.target.value.trim();
        document.getElementById('customerId').value = '';

        if (searchValue.length < 2) {
            hideMembershipCustomerSuggestions();
            return;
        }

        clearTimeout(membershipCustomerTimer);
        membershipCustomerTimer = setTimeout(() => {
            fetch(`./api/customers/search.php?q=${encodeURIComponent(searchValue)}`)
                .then(res => res.json())
                .then(results => renderMembershipCustomerSuggestions(results))
                .catch(() => hideMembershipCustomerSuggestions());
        }, 300);
    });

    document.addEventListener('click', (event) => {
        if (!membershipCustomerSuggestions.contains(event.target) && event.target !== membershipCustomerSearch) {
            hideMembershipCustomerSuggestions();
        }
    });
}

document.getElementById('addMembershipForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const customerId = document.getElementById('customerId').value;
    const planSelect = document.getElementById('membershipPlanSelect');
    const planId = planSelect.value;
    const planOption = planSelect.selectedOptions[0];
    const startDate = document.getElementById('membershipStartDate').value;

    if (!customerId) {
        Swal.fire({
            icon: 'error',
            title: 'Customer required',
            text: 'Please select a customer from the suggestions.'
        });
        return;
    }

    if (!planId) {
        Swal.fire({
            icon: 'error',
            title: 'Plan required',
            text: 'Please choose a membership plan.'
        });
        return;
    }

    if (!startDate) {
        Swal.fire({
            icon: 'error',
            title: 'Start date required',
            text: 'Please choose a valid membership start date.'
        });
        return;
    }

    const planName = planOption?.dataset?.name || planOption?.textContent || 'Membership';
    const planAmount = parseFloat(planOption?.dataset?.price || '0');

    if (isNaN(planAmount) || planAmount <= 0) {
        Swal.fire({
            icon: 'error',
            title: 'Invalid plan',
            text: 'The selected plan does not have a valid amount.'
        });
        return;
    }

    paymentPlanName.textContent = planName;
    paymentAmountDisplay.textContent = `₱${Number(planAmount).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
    paymentAmountHidden.value = planAmount;
    paymentCustomerIdHidden.value = customerId;
    paymentPlanIdHidden.value = planId;
    paymentStartDateHidden.value = startDate;
    paymentCashInput.value = '';
    paymentChangeDisplay.textContent = '₱0.00';
    paymentErrorText.classList.add('hidden');
    paymentErrorText.textContent = '';

    hideModal(document.getElementById('addMembershipModal'));
    openPaymentModal();
});

paymentCashInput.addEventListener('input', function() {
    const amount = parseFloat(paymentAmountHidden.value) || 0;
    const cashValue = parseFloat(this.value);
    const isValidCash = !isNaN(cashValue);

    if (!isValidCash) {
        paymentErrorText.textContent = 'Please enter a valid cash amount.';
        paymentErrorText.classList.remove('hidden');
        paymentChangeDisplay.textContent = '₱0.00';
        return;
    }

    const change = cashValue - amount;
    paymentChangeDisplay.textContent = `₱${Number(change >= 0 ? change : 0).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;

    if (change < 0) {
        paymentErrorText.textContent = 'Insufficient payment.';
        paymentErrorText.classList.remove('hidden');
    } else {
        paymentErrorText.classList.add('hidden');
        paymentErrorText.textContent = '';
    }
});

paymentModalForm.addEventListener('submit', function(e) {
    e.preventDefault();

    const amount = parseFloat(paymentAmountHidden.value) || 0;
    const cash = parseFloat(paymentCashInput.value);
    const change = cash - amount;

    if (isNaN(cash) || cash < amount) {
        paymentErrorText.textContent = 'Cash must be numeric and at least the amount due.';
        paymentErrorText.classList.remove('hidden');
        return;
    }

    const payload = new FormData(this);
    payload.set('change', change.toFixed(2));

    fetch('./api/payments/store.php', {
        method: 'POST',
        body: payload
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Payment completed',
                text: 'Membership payment has been submitted successfully.'
            });
            hideModal(paymentModal);
            closeAddMembership();
            loadMembership();
        } else {
            Swal.fire({ 
                icon: 'error',
                title: data.title || 'Payment Error',
                text: data.message || (data.errors ? data.errors.join(', ') : 'Unable to complete payment.')
            });
        }
    })
    .catch(() => {
        Swal.fire({
            icon: 'error',
            title: 'Network error',
            text: 'Unable to submit payment right now.'
        });
    });
});

function renderMembershipCustomerSuggestions(results) {
    if (!Array.isArray(results) || results.length === 0) {
        hideMembershipCustomerSuggestions();
        return;
    }

    membershipCustomerSuggestions.innerHTML = '';
    results.slice(0, 2).forEach((customer) => {
        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-violet-50 focus:bg-violet-50';
        button.textContent = customer.name;
        button.addEventListener('click', () => {
            membershipCustomerSearch.value = customer.name;
            document.getElementById('customerId').value = customer.id;
            hideMembershipCustomerSuggestions();
        });
        membershipCustomerSuggestions.appendChild(button);
    });
    membershipCustomerSuggestions.classList.remove('hidden');
}

function hideMembershipCustomerSuggestions() {
    membershipCustomerSuggestions.classList.add('hidden');
    membershipCustomerSuggestions.innerHTML = '';
}

function closeUpdatePlanModal(){
    document.getElementById('updatePlanModal').classList.add('hidden');
}

document.getElementById('addPlanForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    fetch('./api/plans/store.php', {
        method: 'POST',
        body: new FormData(this)
    }).then(res => res.json())
    .then(data => {
        console.log('hello');
        if (data.status == 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Plan created successfully!',
                text: 'The plan has been created.'
            });
            loadPlans();
            this.reset();
            closeAddPlan();
        }
        else{
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message
            });
        }
    })

});

document.getElementById('updatePlanForm').addEventListener('submit', function(e) {
    e.preventDefault();

    fetch('./api/plans/update.php', {
        method: 'POST',
        body: new FormData(this)
    }).then(res => res.json())
    .then(data => {
        console.log('hello');
        if (data.status == 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Updated successfully!',
                text: 'The plan has been updated.'
            });
            loadPlans();
            closeUpdatePlanModal();
        }
        else{
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message
            });
        }
    })
})

document.getElementById('updateMembershipForm').addEventListener('submit', function(e) {
    e.preventDefault();

    fetch('./api/membership/update.php', {
        method: 'POST',
        body: new FormData(this)
    }).then(res => res.json())
    .then(data => {
        if (data.status == 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Updated successfully!',
                text: 'The membership has been updated.'
            });
            loadMembership();
            closeUpdateMembershipModal();
        }
        else{
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message
            });
        }
    })
})

function editPlan(id){
    openUpdatePlanModal();

    fetch(`./api/plans/get.php?id=${id}`)
    .then(res => res.json())
    .then(data => {
        document.getElementById('update_plan').value = data.name;
        document.getElementById('update_duration').value = data.duration;
        document.getElementById('update_price').value = data.price;
        document.getElementById('planId').value = id;
    });
}

function deletePlan(id){
    Swal.fire({
        icon: 'warning',
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((res) => {
        if (res.isConfirmed){
            fetch('./api/plans/destroy.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted successfully!',
                        text: 'The plan has been deleted.'
                    });
                    loadPlans();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to delete plan.'
                    });
                }
            });
        }
    })
}

function updateMembership(id){
    openUpdateMembershipModal();

    fetch(`./api/membership/get.php?id=${id}`)
    .then(res => res.json())
    .then(data => {
        document.getElementById('updateCustomerName').value = data.customer_name;
        document.getElementById('updateMembershipStartDate').value = data.start_date;
        document.getElementById('updateMembershipId').value = data.id;

        // Populate plan select
        const planSelect = document.getElementById('updateMembershipPlanSelect');
        planSelect.innerHTML = '<option value="">Select plan</option>';
        // Assuming plans are loaded, but to be safe, fetch again or use existing
        fetch('./api/plans/display.php')
        .then(res => res.json())
        .then(plans => {
            plans.forEach(p => {
                const option = document.createElement('option');
                option.value = p.id;
                option.dataset.price = p.price;
                option.dataset.name = p.name;
                option.textContent = `${p.name} - ₱${Number(p.price).toLocaleString()} (${p.duration == 1 ? p.duration + ' mo' : p.duration + ' mos'})`;
                if (p.id == data.plan_id) option.selected = true;
                planSelect.appendChild(option);
            });
        });
    });
}

function deleteMembership(id){
    Swal.fire({
        icon: 'warning',
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((res) => {
        if (res.isConfirmed){
            fetch('./api/membership/destroy.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted successfully!',
                        text: 'The membership has been deleted.'
                    });
                    loadMembership();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to delete membership.'
                    });
                }
            });
        }
    })
}


// Render or display customer's data
function renderData(data){

    next.disabled = false;
    prev.disabled = false;

    document.getElementById('membershipTable').innerHTML = '';
        data.forEach((d) => {
            let color = new Date(d.end) > Date.now() ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600';
            document.getElementById('membershipTable').innerHTML += `
                            <tr>
                                <td class="px-6 py-3">${d.customer}</td>
                                <td class="px-6 py-3">${d.plan}</td>
                                <td class="px-6 py-3">${d.start}</td>
                                <td class="px-6 py-3">${d.end}</td>
                                <td class="px-6 py-3 flex items-center"><span class="${color} px-2 py-1 rounded-full">${new Date(d.end) > Date.now() ? 'Active' : 'Expired'}</span></td>
                                ${window.isAdmin ? `
                                <td class="px-6 py-3">
                                    <div class="flex gap-2">
                                        <button class="bg-blue-500 p-2 rounded-md text-md hover:bg-blue-400" onclick="updateMembership(${d.id})">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="26" height="26" viewBox="0 0 24 24" style="color: rgb(255, 255, 255);"><path fill="currentColor" d="M16.293 2.293a1 1 0 0 1 1.414 0l4 4a1 1 0 0 1 0 1.414l-13 13A1 1 0 0 1 8 21H4a1 1 0 0 1-1-1v-4a1 1 0 0 1 .293-.707l10-10zM14 7.414l-9 9V19h2.586l9-9zm4 1.172L19.586 7L17 4.414L15.414 6z"></path></svg>
                                        </button>
                                        
                                        <button class="bg-red-500 p-2 rounded-md text-md hover:bg-red-400" onclick="deleteMembership(${d.id})">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="26" height="26" viewBox="0 0 24 24" style="color: rgb(255, 255, 255);"><path fill="currentColor" d="M7 4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2h4a1 1 0 1 1 0 2h-1.069l-.867 12.142A2 2 0 0 1 17.069 22H6.93a2 2 0 0 1-1.995-1.858L4.07 8H3a1 1 0 0 1 0-2h4zm2 2h6V4H9zM6.074 8l.857 12H17.07l.857-12zM10 10a1 1 0 0 1 1 1v6a1 1 0 1 1-2 0v-6a1 1 0 0 1 1-1m4 0a1 1 0 0 1 1 1v6a1 1 0 1 1-2 0v-6a1 1 0 0 1 1-1"></path></svg>
                                        </button>
                                        
                                    </div>
                                </td>
                                ` : ''}
                            </tr>
            `;
        });
        /*<button class="bg-red-500 p-2 rounded-md text-md hover:bg-red-400" id="delete-customer" onclick="deleteCustomer(${d.id})">
                <img src="./images/delete.png" alt="">
        </button>
         */                                          
        // Display pagination when length of data is 7 above
        if (data.length < 7 && page == 1) document.getElementById('pagination').classList.add('hidden');
       else document.getElementById('pagination').classList.remove('hidden');

       if (data.length < 7) next.disabled = true;
       if (page == 1) prev.disabled = true;
}

function loadMembership(){
    fetch('./api/membership/display.php')
    .then(res => res.json())
    .then(data => {
        
        renderData(data);
    })
    
}

loadMembership();

document.getElementById('planFilter').addEventListener('change', function(){
    let val = this.value;

    fetch(`./api/membership/display.php?plan=${val}`)
    .then(res => res.json())
    .then(data => {
        renderData(data);
    })

})

// Filter customer by membership
document.getElementById('statusFilter').addEventListener('change', function(){
    let val = this.value;

    fetch(`./api/membership/display.php`)
    .then(res => res.json())
    .then(data => {
        let filter =  '';
        if (val == 'active'){
            filter = data.filter(d => {
                const end = new Date(d.end);
                return end > Date.now();
            });
        }
        else{
            filter = data.filter(d => {
                const end = new Date(d.end);
                return end < Date.now();
            });
        }
        renderData(filter);
    })

})

// Live search by name
document.getElementById('searchInput').addEventListener('input', (e) => {
    e.preventDefault();
    debounce(e.target.value);
})

// Debouncing technique for controlling live search
let timeout;

function debounce(text){
    clearTimeout(timeout);

    timeout = setTimeout(() =>{
        fetch(`./api/membership/display.php?search=${text}`)
        .then(res => res.json())
        .then(data => {
            renderData(data);
        })
    }, 1000)
}