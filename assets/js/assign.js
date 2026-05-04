
// Open add customer form
function openAddModal() { document.getElementById('addTrainer').classList.remove('hidden'); }

// Close add customer form
function closeAddModal() { 
    document.getElementById('addTrainer').classList.add('hidden'); 
    document.getElementById('assignForm').reset();
    document.getElementById('customerId').value = '';
    document.getElementById('trainerId').value = '';
    document.getElementById('customerSuggestions').classList.add('hidden');
    document.getElementById('trainerSuggestions').classList.add('hidden');
}

let page = 1;

const next = document.getElementById('next');
const prev = document.getElementById('prev');
// Pagination
next.addEventListener('click', (e) => {
    e.preventDefault();
    loadAssign(page + 1);
})

prev.addEventListener('click', (e) => {
    e.preventDefault();
    loadAssign(page - 1);
})

// Render or display customer's data
function renderData(data){

    next.disabled = false;
    prev.disabled = false;

    document.getElementById('assignTable').innerHTML = '';

    data.forEach((d) => {
        const row = document.createElement('tr');
        row.className = 'hover:bg-gray-50';
        row.innerHTML = `
            <td class="px-6 py-4">${d.trainee}</td>
            <td class="px-6 py-4">${d.trainer}</td>
            <td class="px-6 py-4">${d.start}</td>
            <td class="px-6 py-4">${d.end}</td>
            <td class="px-6 py-4">
                <span class="px-2 py-1 rounded text-sm ${d.session === 'Ongoing' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'}">${d.session}</span>
            </td>
            <td class="px-6 py-3">
                                    <div class="flex gap-2">
                                        <button class="bg-blue-500 hover:bg-blue-400 p-2 rounded-md text-md" onclick="updateAssign(${d.id})">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="26" height="26" viewBox="0 0 24 24" style="color: rgb(255, 255, 255);"><path fill="currentColor" d="M16.293 2.293a1 1 0 0 1 1.414 0l4 4a1 1 0 0 1 0 1.414l-13 13A1 1 0 0 1 8 21H4a1 1 0 0 1-1-1v-4a1 1 0 0 1 .293-.707l10-10zM14 7.414l-9 9V19h2.586l9-9zm4 1.172L19.586 7L17 4.414L15.414 6z"></path></svg>
                                        </button>
                                        ${window.isAdmin ? `
                                        <button class="bg-red-500 hover:bg-red-400 p-2 rounded-md text-md" onclick="deleteAssign(${d.id})">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="26" height="26" viewBox="0 0 24 24" style="color: rgb(255, 255, 255);"><path fill="currentColor" d="M7 4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2h4a1 1 0 1 1 0 2h-1.069l-.867 12.142A2 2 0 0 1 17.069 22H6.93a2 2 0 0 1-1.995-1.858L4.07 8H3a1 1 0 0 1 0-2h4zm2 2h6V4H9zM6.074 8l.857 12H17.07l.857-12zM10 10a1 1 0 0 1 1 1v6a1 1 0 1 1-2 0v-6a1 1 0 0 1 1-1m4 0a1 1 0 0 1 1 1v6a1 1 0 1 1-2 0v-6a1 1 0 0 1 1-1"></path></svg>
                                        </button>
                                        ` : ''}
                                    </div>
                                </td>
        `;
        document.getElementById('assignTable').appendChild(row);
    });

    // Display pagination when length of data is 7 above
    if (data.length < 7 && page == 1) {
        document.getElementById('pagination').classList.add('hidden');
    } else {
        document.getElementById('pagination').classList.remove('hidden');
    }

    if (data.length < 7) next.disabled = true;
    if (page == 1) prev.disabled = true;
}

// Load trainers in table
function loadAssign(){
    const search = document.getElementById('searchInput').value;
    const end = document.getElementById('end').value;
    const session = document.getElementById('session').value;
    fetch(`./api/assign/display.php?page=${page}&search=${encodeURIComponent(search)}&end=${end}&session=${session}`)
    .then(res => res.json())
    .then(data => {
        document.getElementById('page').textContent = page;
        renderData(data);
    })
    .catch(err => console.error(err))
}

loadAssign();

// Add new trainer
document.getElementById('assignForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const customerId = document.getElementById('customerId').value;
    const trainerId = document.getElementById('trainerId').value;
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;

    if (!customerId || !trainerId) {
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            text: 'Please select a customer and trainer from the suggestions.'
        });
        return;
    }

    if (new Date(endDate) < new Date(startDate)) {
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            text: 'End date cannot be before start date.'
        });
        return;
    }

    fetch('./api/assign/store.php', {
        method: 'POST',
        body: new FormData(this)
    })
    .then(res => res.json())
    .then(data => {
        if (data.status == 'success'){
            closeAddModal();
            loadAssign();
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Assignment created successfully'
            })
        }
        else{
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message
            })
        }
    })
    .catch(err => console.error(err))
})

document.getElementById('end').addEventListener('change', function(e){
    page = 1;
    loadAssign();
});

document.getElementById('session').addEventListener('change', (e) => {
    page = 1;
    loadAssign();
});

// Live search by name
document.getElementById('searchInput').addEventListener('input', (e) => {
    e.preventDefault();
    debounce(e.target.value);
})

// Debouncing technique for controlling live search
let timeout;

function debounce(text){
    clearTimeout(timeout);

    timeout = setTimeout(() => {
        page = 1;
        loadAssign();
    }, 1000)
}

// Delete trainer
function deleteAssign(id){
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
        if (res.isConfirmed) {
            fetch('./api/assign/destroy.php', {
                method: 'POST',
                headers: {
                    'Content-Type' : 'application/json'
                },
                body: JSON.stringify({ id })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status == 'success'){
                    loadAssign();
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Assignment deleted successfully'
                    })
                }
                else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message
                    })
                }
            })
            .catch(err => console.error(err))
        }
    })
}

function openUpdate(){
    document.getElementById('updateTrainer').classList.remove('hidden');
}

function closeUpdate(){
    document.getElementById('updateTrainer').classList.add('hidden');
    document.getElementById('updateForm').reset();
    document.getElementById('updateCustomerId').value = '';
    document.getElementById('updateTrainerId').value = '';
    document.getElementById('updateCustomerSuggestions').classList.add('hidden');
    document.getElementById('updateTrainerSuggestions').classList.add('hidden');
}

function updateAssign(id){
    openUpdate();

    fetch('./api/assign/get.php?id=' + id)
    .then(res => res.json())
    .then(data => {
        document.getElementById('updateAssignId').value = data.id;
        document.getElementById('updateCustomerSearchInput').value = data.trainee;
        document.getElementById('updateCustomerId').value = data.customer_id;
        document.getElementById('updateTrainerSearchInput').value = data.trainer;
        document.getElementById('updateTrainerId').value = data.trainer_id;
        document.getElementById('updateStartDate').value = data.start;
        document.getElementById('updateEndDate').value = data.end;
    })
    .catch(err => console.error(err))
}

document.getElementById('updateForm').addEventListener('submit', function(e){
    e.preventDefault();

    const customerId = document.getElementById('updateCustomerId').value;
    const trainerId = document.getElementById('updateTrainerId').value;
    const startDate = document.getElementById('updateStartDate').value;
    const endDate = document.getElementById('updateEndDate').value;

    if (!customerId || !trainerId) {
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            text: 'Please select a customer and trainer from the suggestions.'
        });
        return;
    }

    if (new Date(endDate) < new Date(startDate)) {
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            text: 'End date cannot be before start date.'
        });
        return;
    }

    fetch('./api/assign/update.php', {
        method: 'POST',
        body: new FormData(this)
    })
    .then(res => res.json())
    .then(data => {
        if (data.status == 'success'){
            closeUpdate();
            loadAssign();
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Assignment updated successfully'
            })
        }
        else{
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message
            })
        }
    })
    .catch(err => console.error(err))
});

// Live search for customers in add modal
document.getElementById('customerSearchInput').addEventListener('input', function() {
    const query = this.value;
    if (query.length < 2) {
        document.getElementById('customerSuggestions').classList.add('hidden');
        return;
    }
    fetch(`./api/customers/search.php?q=${encodeURIComponent(query)}`)
    .then(res => res.json())
    .then(data => {
        renderCustomerSuggestions(data, 'customerSuggestions', 'customerId', 'customerSearchInput');
    });
});

// Live search for trainers in add modal
document.getElementById('trainerSearchInput').addEventListener('input', function() {
    const query = this.value;
    if (query.length < 2) {
        document.getElementById('trainerSuggestions').classList.add('hidden');
        return;
    }
    fetch(`./api/trainers/search.php?q=${encodeURIComponent(query)}`)
    .then(res => res.json())
    .then(data => {
        renderTrainerSuggestions(data, 'trainerSuggestions', 'trainerId', 'trainerSearchInput');
    });
});

// Live search for customers in update modal
document.getElementById('updateCustomerSearchInput').addEventListener('input', function() {
    const query = this.value;
    if (query.length < 2) {
        document.getElementById('updateCustomerSuggestions').classList.add('hidden');
        return;
    }
    fetch(`./api/customers/search.php?q=${encodeURIComponent(query)}`)
    .then(res => res.json())
    .then(data => {
        renderCustomerSuggestions(data, 'updateCustomerSuggestions', 'updateCustomerId', 'updateCustomerSearchInput');
    });
});

// Live search for trainers in update modal
document.getElementById('updateTrainerSearchInput').addEventListener('input', function() {
    const query = this.value;
    if (query.length < 2) {
        document.getElementById('updateTrainerSuggestions').classList.add('hidden');
        return;
    }
    fetch(`./api/trainers/search.php?q=${encodeURIComponent(query)}`)
    .then(res => res.json())
    .then(data => {
        renderTrainerSuggestions(data, 'updateTrainerSuggestions', 'updateTrainerId', 'updateTrainerSearchInput');
    });
});

function renderCustomerSuggestions(suggestions, containerId, hiddenId, inputId) {
    const container = document.getElementById(containerId);
    container.innerHTML = '';
    if (suggestions.length > 0) {
        suggestions.forEach(s => {
            const div = document.createElement('div');
            div.className = 'px-3 py-2 hover:bg-gray-100 cursor-pointer';
            div.textContent = s.name;
            div.onclick = () => {
                document.getElementById(inputId).value = s.name;
                document.getElementById(hiddenId).value = s.id;
                container.classList.add('hidden');
            };
            container.appendChild(div);
        });
        container.classList.remove('hidden');
    } else {
        container.classList.add('hidden');
    }
}

function renderTrainerSuggestions(suggestions, containerId, hiddenId, inputId) {
    const container = document.getElementById(containerId);
    container.innerHTML = '';
    if (suggestions.length > 0) {
        suggestions.forEach(s => {
            const div = document.createElement('div');
            div.className = 'px-3 py-2 hover:bg-gray-100 cursor-pointer';
            div.textContent = s.name;
            div.onclick = () => {
                document.getElementById(inputId).value = s.name;
                document.getElementById(hiddenId).value = s.id;
                container.classList.add('hidden');
            };
            container.appendChild(div);
        });
        container.classList.remove('hidden');
    } else {
        container.classList.add('hidden');
    }
}