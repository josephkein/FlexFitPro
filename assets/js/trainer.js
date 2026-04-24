
// Open add customer form
function openAddModal() { document.getElementById('addTrainer').classList.remove('hidden'); }

// Close add customer form
function closeAddModal() { 
    document.getElementById('addTrainer').classList.add('hidden'); 
    document.getElementById('trainerForm').reset();
}

let page = 1;

const next = document.getElementById('next');
const prev = document.getElementById('prev');
// Pagination
next.addEventListener('click', (e) => {
    e.preventDefault();
    page++;
    fetch(`./api/trainers/display.php?page=${page}`)
    .then(res => res.json())
    .then(data => {
        document.getElementById('page').textContent = page;
        renderData(data);
    })
})

prev.addEventListener('click', (e) => {
    e.preventDefault();
    page--;
    fetch(`./api/trainers/display.php?page=${page}`)
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

    document.getElementById('trainerTable').innerHTML = '';

        data.forEach((d) => {
            let status = d.capacity != d.trainees ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600';
            document.getElementById('trainerTable').innerHTML += `
                            <tr>
                                <td class="px-6 py-3">${d.trainer}</td>
                                <td class="px-6 py-3">${d.rate}</td>
                                <td class="px-6 py-3">${d.capacity}</td>
                                <td class="px-6 py-3">${d.trainees}</td>
                                <td class="px-6 py-3">
                                <span class="px-2 py-1 rounded-full ${status}">${d.capacity == d.trainees ? 'Full' : 'Available'}</span>
                                </td>
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
            `;
        })

        // Display pagination when length of data is 7 above
        if (data.length < 7 && page == 1) document.getElementById('pagination').classList.add('hidden');
       else document.getElementById('pagination').classList.remove('hidden');

       if (data.length < 7) next.disabled = true;
       if (page == 1) prev.disabled = true;
}

// Load trainers in table
function loadTrainers(){
    fetch('./api/trainers/display.php')
    .then(res => res.json())
    .then(data => {
        renderData(data);
    })
    .catch(err => console.error(err))
}

loadTrainers();

// Add new trainer
document.getElementById('trainerForm').addEventListener('submit', function(e) {
    e.preventDefault();

    fetch('./api/trainers/store.php', {
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

// Filter trainer by status
document.getElementById('status').addEventListener('change', function(){
    let val = this.value;

    fetch(`./api/trainers/display.php`)
    .then(res => res.json())
    .then(data => {
        let filtered;

        if (val == 'available'){
            filtered = data.filter(d => d.capacity != d.trainees);
        }
        else if (val == 'full'){
            filtered = data.filter(d => d.capacity == d.trainees)
        }
        else{
            filtered = data;
        }
        renderData(filtered);
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
        fetch(`./api/trainers/display.php?search=${text}`)
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

function updateCustomer(id){
    openUpdate();

    console.log(id);
    fetch('./api/trainers/get.php?id=' + id)
    .then(res => res.json())
    .then(data => {
        let name = data.customer_name.split(' ');
        document.getElementById('up_first').value = name[0];
        document.getElementById('up_last').value = name[1];
        document.getElementById('up_type').value = data.customer_type;
    })

}