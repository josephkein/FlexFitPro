
// Open add customer form
function openAddModal() { document.getElementById('addModal').classList.remove('hidden'); }

// Close add customer form
function closeAddModal() { 
    document.getElementById('addModal').classList.add('hidden'); 
    document.getElementById('payment_form').reset();
}

let page = 1;

const next = document.getElementById('next');
const prev = document.getElementById('prev');

let paymentT = document.getElementById('payment_type');
let date = document.getElementById('date');

// Pagination
next.addEventListener('click', (e) => {
    e.preventDefault();
    page++;
    fetch(`./api/payments/display.php?page=${page}&type=${paymentT.value}&date=${date.value}`)
    .then(res => res.json())
    .then(data => {
        document.getElementById('page').textContent = page;
        renderData(data);
    })
})

prev.addEventListener('click', (e) => {
    e.preventDefault();
    page--;
    fetch(`./api/payments/display.php?page=${page}&type=${paymentT.value}&date=${date.value}`)
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

    document.getElementById('paymentTable').innerHTML = '';

        data.forEach((d) => {
            let status = d.capacity != d.trainees ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600';
            document.getElementById('paymentTable').innerHTML += `
                            <tr>
                                <td class="px-6 py-3">${d.date}</td>
                                <td class="px-6 py-3">${d.customer}</td>
                                <td class="px-6 py-3">${d.type}</td>
                                <td class="px-6 py-3">₱${d.amount}</td>
                                <td class="px-6 py-3">${d.staff}</td>
                                ${window.isAdmin ? `
                                <td class="px-6 py-3">
                                    <div class="flex gap-2">
                                        <button class="bg-blue-500 hover:bg-blue-400 p-2 rounded-md text-md" onclick="updatePayments(${d.id})">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="26" height="26" viewBox="0 0 24 24" style="color: rgb(255, 255, 255);"><path fill="currentColor" d="M16.293 2.293a1 1 0 0 1 1.414 0l4 4a1 1 0 0 1 0 1.414l-13 13A1 1 0 0 1 8 21H4a1 1 0 0 1-1-1v-4a1 1 0 0 1 .293-.707l10-10zM14 7.414l-9 9V19h2.586l9-9zm4 1.172L19.586 7L17 4.414L15.414 6z"></path></svg>
                                        </button>
                                        
                                        <button class="bg-red-500 hover:bg-red-400 p-2 rounded-md text-md" onclick="deletePayments(${d.id})">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="26" height="26" viewBox="0 0 24 24" style="color: rgb(255, 255, 255);"><path fill="currentColor" d="M7 4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2h4a1 1 0 1 1 0 2h-1.069l-.867 12.142A2 2 0 0 1 17.069 22H6.93a2 2 0 0 1-1.995-1.858L4.07 8H3a1 1 0 0 1 0-2h4zm2 2h6V4H9zM6.074 8l.857 12H17.07l.857-12zM10 10a1 1 0 0 1 1 1v6a1 1 0 1 1-2 0v-6a1 1 0 0 1 1-1m4 0a1 1 0 0 1 1 1v6a1 1 0 1 1-2 0v-6a1 1 0 0 1 1-1"></path></svg>
                                        </button>
                                    </div>
                                </td>
                                ` : ''}
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
function loadPayments(){
    fetch('./api/payments/display.php')
    .then(res => res.json())
    .then(data => {
        renderData(data);
    })
    .catch(err => console.error(err))
}

loadPayments();

// Add new trainer
document.getElementById('payment_form').addEventListener('submit', function(e) {
    e.preventDefault();

    fetch('./api/payments/store.php', {
        method: 'POST',
        body: new FormData(this)
    })
    .then(res => res.json())
    .then(data => {
        if (data.status == 'success'){
            closeAddModal();
            this.reset();
            Swal.fire({
                icon: 'success',
                title: 'Successfullt Added!',
                text: 'Payment added successfully'
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
        loadPayments();
    })
})

// Filter payments by type
document.getElementById('payment_type').addEventListener('change', function(){
    let val = this.value;

    fetch(`./api/payments/display.php?type=${val}&date=${date.value}`)
    .then(res => res.json())
    .then(data => {
        renderData(data);
    })

})

// Filter payments by date
document.getElementById('date').addEventListener('change', function(){
    let val = this.value;

    fetch(`./api/payments/display.php?date=${val}&type=${paymentT.value}`)
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
        fetch(`./api/payments/display.php?search=${text}`)
        .then(res => res.json())
        .then(data => {
            renderData(data);
        })
    }, 1000)
}

// Delete trainer
function deletePayments(id){
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
            fetch ('./api/payments/destroy.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id })
            })
            .then(res => res.json())
            .then(data => { 
                if (data.status == 'success'){
                    console.log(data.id);
                    Swal.fire({
                        title: "Deleted!",  
                        text: "Payment successfully deleted!",
                        icon: "success"
                    })
                    loadPayments();
                }
            })
        }
    })
    
}

document.getElementById('update-form').addEventListener('submit', function(e){
    e.preventDefault();

    fetch('./api/payments/update.php', {
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
                title: 'Successfullt updated!',
                text: 'Payment updated successfully'
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
        loadPayments();
    })
});
 

function openUpdate(){
    document.getElementById('updatePayment').classList.remove('hidden');
}

function closeUpdate(){
    document.getElementById('updatePayment').classList.add('hidden');
}

function updatePayments(id){
    openUpdate();

    fetch('./api/payments/get.php?id=' + id)
    .then(res => res.json())
    .then(data => {
        document.getElementById('up_type').value = data.payment_type;
        document.getElementById('up_amount').value = data.amount;
    })

}