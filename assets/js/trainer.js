
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
                                <td class="px-6 py-3">${d.contact}</td>
                                <td class="px-6 py-3">${d.rate}</td>
                                <td class="px-6 py-3">${d.capacity}</td>
                                <td class="px-6 py-3">${d.trainees}</td>
                                <td class="px-6 py-3">
                                <span class="px-2 py-1 rounded-full ${status}">${d.capacity == d.trainees ? 'Full' : 'Available'}</span>
                                </td>
                                <td class="px-6 py-3">
                                    <div class="flex gap-2">
                                        <button class="bg-blue-500 p-2 rounded-md text-md" onclick="updateTrainer(${d.trainer_id})">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="26" height="26" viewBox="0 0 24 24" style="color: rgb(255, 255, 255);"><path fill="currentColor" d="M16.293 2.293a1 1 0 0 1 1.414 0l4 4a1 1 0 0 1 0 1.414l-13 13A1 1 0 0 1 8 21H4a1 1 0 0 1-1-1v-4a1 1 0 0 1 .293-.707l10-10zM14 7.414l-9 9V19h2.586l9-9zm4 1.172L19.586 7L17 4.414L15.414 6z"></path></svg>
                                        </button>
                                        ${window.isAdmin ? `
                                        <button class="bg-red-500 p-2 rounded-md text-md" onclick="deleteTrainer(${d.trainer_id})">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="26" height="26" viewBox="0 0 24 24" style="color: rgb(255, 255, 255);"><path fill="currentColor" d="M7 4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2h4a1 1 0 1 1 0 2h-1.069l-.867 12.142A2 2 0 0 1 17.069 22H6.93a2 2 0 0 1-1.995-1.858L4.07 8H3a1 1 0 0 1 0-2h4zm2 2h6V4H9zM6.074 8l.857 12H17.07l.857-12zM10 10a1 1 0 0 1 1 1v6a1 1 0 1 1-2 0v-6a1 1 0 0 1 1-1m4 0a1 1 0 0 1 1 1v6a1 1 0 1 1-2 0v-6a1 1 0 0 1 1-1"></path></svg>
                                        </button>
                                        ` : ''}
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
                text: 'Trainer added successfully'
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
        loadTrainers();
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

let rateTimeout;

function debounceRate(){
    clearTimeout(rateTimeout);

    rateTimeout = setTimeout(() => {
        const min = document.getElementById('min').value;
        const max = document.getElementById('max').value;

        fetch(`./api/trainers/display.php?search=${document.getElementById('searchInput').value}&min=${min}&max=${max}`)
        .then(res => res.json())
        .then(data => {
            renderData(data);
        })
    }, 500)
}

document.getElementById('min').addEventListener('input', debounceRate);
document.getElementById('max').addEventListener('input', debounceRate);


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

// Delete trainer
function deleteTrainer(id){
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
            fetch ('./api/trainers/destroy.php', {
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
                    loadTrainers();
                }
            })
        }
    })
    
}

document.getElementById('update-form').addEventListener('submit', function(e){
    e.preventDefault();

    fetch('./api/trainers/update.php', {
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
                title: 'Successfully updated!',
                text: 'Trainer updated successfully'
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
        loadTrainers();
    })
});

function openUpdate(){
    document.getElementById('updateTrainer').classList.remove('hidden');
}

function closeUpdate(){
    document.getElementById('updateTrainer').classList.add('hidden');
}

function updateTrainer(id){
    openUpdate();

    fetch('./api/trainers/get.php?id=' + id)
    .then(res => res.json())
    .then(data => {
        document.getElementById('up_first').value = data.first_name;
        document.getElementById('up_last').value = data.last_name;
        document.getElementById('up_rate').value = data.rate;
        document.getElementById('up_cap').value = data.capacity;
        document.getElementById('up_contact').value = String(data.contact);
        document.getElementById('up_tid').value = id;
    })

}