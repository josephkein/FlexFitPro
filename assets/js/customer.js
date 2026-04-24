
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
    page++;
    fetch(`./api/customers/display.php?page=${page}`)
    .then(res => res.json())
    .then(data => {
        document.getElementById('page').textContent = page;
        renderData(data);
    })
})

prev.addEventListener('click', (e) => {
    e.preventDefault();
    page--;
    fetch(`./api/customers/display.php?page=${page}`)
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
            let type = d.type == 'student' ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-600';
            let color = d.trainer == null ? 'text-gray-500' : '';
            document.getElementById('membersTable').innerHTML += `
                            <tr>
                                <td class="px-6 py-3">${d.name}</td>
                                <td class="px-6 py-3 flex items-center"><span class="${type} py-1 px-3 rounded-full">${d.type}</span></td>
                                <td class="px-6 py-3">${d.member == null ? 'None' : 'Member'}</td>
                                <td class="px-6 py-3 ${color}">${d.trainer == null ? 'None' : d.trainer}</td>
                                <td class="px-6 py-3">
                                    <div class="flex gap-2">
                                        <button class="bg-blue-500 p-2 rounded-md text-md hover:bg-blue-400" id="update-customer" onclick="updateCustomer(${d.id})">
                                            <img src="./images/edit.png" alt="">
                                        </button>
                                    </div>
                                </td>
                            </tr>
            `;
        })

        // Display pagination when length of data is 7 above
        if (data.length < 7 && page == 1) document.getElementById('pagination').classList.add('hidden');
       else document.getElementById('pagination').classList.remove('hidden');

       if (data.length < 7) next.disabled = true;
       if (page == 1) prev.disabled = true;
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
// function deleteCustomer(id){
//     Swal.fire({
//         icon: 'warning',
//         title: 'Are you sure?',
//         text: "You won't be able to revert this!",
//         showCancelButton: true,
//         confirmButtonColor: "#3085d6",
//         cancelButtonColor: "#d33",
//         confirmButtonText: "Yes, delete it!"
//     })
//     .then((res) => {
//         if (res.isConfirmed){
//             fetch ('./api/customers/destroy.php', {
//                 method: 'POST',
//                 headers: {
//                     'Content-Type': 'application/x-www-form-urlencoded'
//                 },
//                 body: new URLSearchParams({ id })
//             })
//             .then(res => res.json())
//             .then(data => {
//                 if (data.status == 'success'){
//                     Swal.fire({
//                         title: "Deleted!",
//                         text: "Customer successfully deleted!",
//                         icon: "success"
//                     })
//                     loadCustomers();
//                 }
//             })
//         }
//     })
    
// }
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
    })

}