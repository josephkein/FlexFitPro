
// Open add customer form
function openAddModal() { document.getElementById('addModal').classList.remove('hidden'); }

// Close add customer form
function closeAddModal() { 
    document.getElementById('addModal').classList.add('hidden'); 
    document.getElementById('customer-form').reset();
}
let page = 1;

const next = document.getElementById('next');
const prev = document.getElementById('prev');
// Pagination
next.addEventListener('click', (e) => {
    e.preventDefault();
    let order = document.getElementById('orderFilter');
    let type = document.getElementById('typeFilter');
    let membership = document.getElementById('membershipFilter');
    page++;
    fetch(`./api/customers/display.php?page=${page}&order=${order.value}&type=${type.value}&membership=${membership.value}`)
    .then(res => res.json())
    .then(data => {
        document.getElementById('page').textContent = page;
        renderData(data);
    })
})

prev.addEventListener('click', (e) => {
    e.preventDefault();
    let order = document.getElementById('orderFilter');
    let type = document.getElementById('typeFilter');
    let membership = document.getElementById('membershipFilter');
    page--;
    fetch(`./api/customers/display.php?page=${page}&order=${order.value}&type=${type.value}&membership=${membership.value}`)
    .then(res => res.json())
    .then(data => {
        document.getElementById('page').textContent = page;
        renderData(data);
    })
})


// Render or display customer's data
function renderData(data){

    next.disabled = false;
    prev.disabled = false;

    document.getElementById('membersTable').innerHTML = '';
        data.forEach((d) => {

            let dateNow = new Date().toLocaleString('en-CA');
            let type = d.type == 'student' ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-600';
            let color = d.end < dateNow || d.end == null ? 'text-gray-500' : '';
            
            console.log(dateNow);
            document.getElementById('membersTable').innerHTML += `
                            <tr>
                                <td class="px-6 py-3">${d.id}</td>
                                <td class="px-6 py-3">${d.name}</td>
                                <td class="px-6 py-3"><span class="${type} py-1 px-3 rounded-full">${d.type}</span></td>
                                <td class="px-6 py-3"><span class="${d.membership_status == 'Active' ? 'bg-green-100 text-green-600' : d.membership_status == 'Expired' ? 'bg-red-100 text-red-600' : 'text-gray-500'} py-1 px-3 rounded-full">${d.membership_status}</span></td>
                                <td class="px-6 py-3 ${color}">${d.end < dateNow || d.end == null ? 'None' : d.trainer}</td>
                                <td class="px-6 py-3">
                                    <div class="flex gap-2">
                                        <button class="bg-blue-500 p-2 rounded-md text-md hover:bg-blue-400" id="update-customer" onclick="updateCustomer(${d.id})">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="26" height="26" viewBox="0 0 24 24" style="color: rgb(255, 255, 255);"><path fill="currentColor" d="M16.293 2.293a1 1 0 0 1 1.414 0l4 4a1 1 0 0 1 0 1.414l-13 13A1 1 0 0 1 8 21H4a1 1 0 0 1-1-1v-4a1 1 0 0 1 .293-.707l10-10zM14 7.414l-9 9V19h2.586l9-9zm4 1.172L19.586 7L17 4.414L15.414 6z"></path></svg>
                                        </button>
                                        ${window.isAdmin ? `
                                        <button class="bg-red-500 p-2 rounded-md text-md hover:bg-red-400" onclick="deleteCustomer(${d.id})">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="26" height="26" viewBox="0 0 24 24" style="color: rgb(255, 255, 255);"><path fill="currentColor" d="M7 4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2h4a1 1 0 1 1 0 2h-1.069l-.867 12.142A2 2 0 0 1 17.069 22H6.93a2 2 0 0 1-1.995-1.858L4.07 8H3a1 1 0 0 1 0-2h4zm2 2h6V4H9zM6.074 8l.857 12H17.07l.857-12zM10 10a1 1 0 0 1 1 1v6a1 1 0 1 1-2 0v-6a1 1 0 0 1 1-1m4 0a1 1 0 0 1 1 1v6a1 1 0 1 1-2 0v-6a1 1 0 0 1 1-1"></path></svg>
                                        </button>
                                        ` : ''}
                                        <button class="border border-violet-600 p-2 text-violet-600 hover:bg-gray-100" onclick="logVisit(${d.id})">Log</button>
                                    </div>
                                </td>
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

function openLog(){
    document.getElementById('logModal').classList.remove('hidden');
}



function logVisit(id) {

    openLog();

    fetch('./api/customers/get.php?id=' + id)
    .then(res => res.json())
    .then(data => {
        let name = data.customer_name.split(' ');
        document.getElementById('logFirst').value = name[0];
        document.getElementById('logLast').value = name[1];
        document.getElementById('logType').value = data.customer_type;
        document.getElementById('logId').value = id;
    })
   
}

function visitLog(e){
    
    fetch('./api/payments/store.php', {
            method: 'POST',
            body: new FormData(e)
        })
        .then(res => res.json())
        .then(data => {
            if (data.status == 'success'){
                console.log(data.message);
                Swal.fire({
                    icon: 'success',
                    title: 'Successfullt Logged!',
                    text: 'Visit logged successfully'
                })
                closeLogModal();
                closePaymentModal();
            }
            else{
                console.log(data);
                closeLogModal();
                let icon = data.status == 'pay' ? 'warning' : 'warning';
                let ok = data.status == 'pay' ? 'Go to Payment' : 'OK';
                Swal.fire({
                    icon: icon,
                    title: data.title,
                    text: data.message,
                    confirmButtonText: ok
                }).then(() => {
                    openPaymentModal();
                })
            }

    })
}

document.getElementById('logForm').addEventListener('submit', function(e){
    e.preventDefault();

    fetch('./api/payments/check.php', {
        method: 'POST',
        body: new FormData(this)
    }).then(res => res.json())
    .then(data => {
        if (data.status == 'allow'){
            closeLogModal();
            Swal.fire({
                    icon: 'success',
                    title: 'Successfullt Logged!',
                    text: 'Visit logged successfully'
            });
        }
        else{
            closeLogModal();
            let icon = data.status == 'pay' ? 'warning' : 'warning';
            let ok = data.status == 'pay' ? 'Go to Payment' : 'OK';
            Swal.fire({
                icon: icon,
                title: data.title,
                text: data.message,
                confirmButtonText: ok
            }).then(() => {
                openPaymentModal();
            })
        }
    })


});

document.getElementById('paymentForm').addEventListener('submit', function(e){
    e.preventDefault();

    let amt = document.getElementById('cashInput');

    if (amt < 0){
        Swal.fire({
            icon: 'error',
            title: 'Invalid Amount!',
            text: 'Please enter a valid amount.'
        })
    }
    else{
        visitLog(this);
    }
});

function openPaymentModal(){

    let id = document.getElementById('logId').value;

    fetch('./api/customers/get.php?id=' + id)
    .then(res => res.json())
    .then(data => {
        let name = data.customer_name.split(' ');
        document.getElementById('payFirst').value = name[0];
        document.getElementById('payLast').value = name[1];
        document.getElementById('payType').value = data.customer_type;
        document.getElementById('payCustomerId').value = id;
    })
    
    document.getElementById('paymentModal').classList.remove('hidden');
}

function closePaymentModal(){
    document.getElementById('paymentModal').classList.add('hidden');
}

function closeLogModal(){
    document.getElementById('logModal').classList.add('hidden');
    document.getElementById('logForm').reset();
}

// Load customers in table
function loadCustomers(){
    fetch('./api/customers/display.php')
    .then(res => res.json())
    .then(data => {
        renderData(data);
    })
    .catch(err => console.error(err))
}

loadCustomers();

// Add new customer
document.getElementById('customer-form').addEventListener('submit', function(e) {
    e.preventDefault();

    fetch('./api/customers/store.php', {
        method: 'POST',
        body: new FormData(this)
    })
    .then(res => res.json())
    .then(data => {
        if (data.status == 'success'){
            console.log(data.message);
            closeAddModal();
            this.reset();
            Swal.fire({
                icon: 'success',
                title: 'Successfullt Added!',
                text: 'Customer added successfully'
            })  
        }
        else{
            console.log(data.errors);
            Swal.fire({
                icon: 'error',
                title: 'Cannot be empty!',
                text: 'Inputs cannot be empty. Input something!'
            })
           
        }
        loadCustomers();
    })
})

// Filter customer by type
document.getElementById('typeFilter').addEventListener('change', function(){
    let val = this.value;

    fetch(`./api/customers/display.php?type=${val}`)
    .then(res => res.json())
    .then(data => {
        renderData(data);
    })

})

document.getElementById('membershipFilter').addEventListener('change', function(){
    let val = this.value;

    fetch(`./api/customers/display.php?membership=${val}`)
    .then(res => res.json())
    .then(data => {
        renderData(data);
    })

})

// Filter customer by membership
document.getElementById('orderFilter').addEventListener('change', function(){
    let val = this.value;

    fetch(`./api/customers/display.php?order=${val}`)
    .then(res => res.json())
    .then(data => {
        renderData(data);
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
        fetch(`./api/customers/display.php?search=${text}`)
        .then(res => res.json())
        .then(data => {
            renderData(data);
        })
    }, 1000)
}

// Delete customer
function deleteCustomer(id){
    Swal.fire({
        icon: 'warning',
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    })
    .then((res) => {
        if (res.isConfirmed){
            fetch ('./api/customers/destroy.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({ id })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status == 'success'){
                    Swal.fire({
                        title: "Deleted!",
                        text: "Customer successfully deleted!",
                        icon: "success"
                    })
                    loadCustomers();
                }
            })
        }
    })
    
}
function openUpdate(){
    document.getElementById('updateDiv').classList.remove('hidden');
}

function closeUpdate(){
    document.getElementById('updateDiv').classList.add('hidden');
}

// Update form
document.getElementById('updateCusomter').addEventListener('submit', function(e){
    e.preventDefault();

    fetch('./api/customers/update.php', {
        method: 'POST',
        body: new FormData(this)
    })
    .then(res => res.json())
    .then(data => {
        if (data.status == 'success'){
            console.log(data.message);
            closeUpdate();
            this.reset();
            Swal.fire({
                icon: 'success',
                title: 'Successfullt Added!',
                text: 'Customer added successfully'
            })
        }
        else{
            // console.log(data.errors);
            // Swal.fire({
            //     icon: 'error',
            //     title: 'Cannot be empty!',
            //     text: 'Inputs cannot be empty. Input something!'
            // })
           
        }
        loadCustomers();
    })
});

function updateCustomer(id){
    openUpdate();

    fetch('./api/customers/get.php?id=' + id)
    .then(res => res.json())
    .then(data => {
        let name = data.customer_name.split(' ');
        document.getElementById('up_first').value = name[0];
        document.getElementById('up_last').value = name[1];
        document.getElementById('up_type').value = data.customer_type;
        document.getElementById('up_id').value = id;
    })

}