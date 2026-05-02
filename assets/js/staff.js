function openAddModal() { document.getElementById('addModal').classList.remove('hidden'); }
function closeAddModal() { document.getElementById('addModal').classList.add('hidden'); }

document.getElementById('accForm').addEventListener('submit', function(e) {
    e.preventDefault();

    fetch('./api/staffs/store.php', {
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
                text: data.message
            })
            loadStaffs();
        }
        else{
            console.log(data.errors);
            Swal.fire({
                icon: 'error',
                title: 'Something Went Wrong!',
                text: data.message
            })
           
        }
        // loadStaffs();
    })
})


let page = 1;

const next = document.getElementById('next');
const prev = document.getElementById('prev');
// Pagination
next.addEventListener('click', (e) => {
    e.preventDefault();

    let status = document.getElementById('status');
    let role = document.getElementById('role');
    let search = document.getElementById('searchInput');

    page++;
    fetch(`./api/staffs/display.php?page=${page}&role=${role.value}&status=${status.value}&search=${search.value}`)
    .then(res => res.json())
    .then(data => {
        document.getElementById('page').textContent = page;
        renderData(data);
    })
})

prev.addEventListener('click', (e) => {
    e.preventDefault();

    let status = document.getElementById('status');
    let role = document.getElementById('role');
    let search = document.getElementById('searchInput');

    page--;
    fetch(`./api/staffs/display.php?page=${page}&role=${role.value}&status=${status.value}&search=${search.value}`)
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

    document.getElementById('staffTable').innerHTML = '';
        data.forEach((d) => {
            let status = d.status == 'active' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600';

            document.getElementById('staffTable').innerHTML += `
                            <tr>
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-2">
                                        ${d.username}
                                    </div>
                                </td>
                                <td class="px-6 py-3">${d.role}</td>
                                <td class="px-6 py-3">
                                    <span class="${status} px-2 py-1 rounded-full">${d.status}</span>
                                </td>
                                <td class="px-6 py-3">
                                    <div class="flex gap-2">
                                        <button class="bg-blue-500 hover:bg-blue-400 p-2 rounded-md text-md" onclick="updateStaff(${d.user_id})">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="26" height="26" viewBox="0 0 24 24" style="color: rgb(255, 255, 255);"><path fill="currentColor" d="M16.293 2.293a1 1 0 0 1 1.414 0l4 4a1 1 0 0 1 0 1.414l-13 13A1 1 0 0 1 8 21H4a1 1 0 0 1-1-1v-4a1 1 0 0 1 .293-.707l10-10zM14 7.414l-9 9V19h2.586l9-9zm4 1.172L19.586 7L17 4.414L15.414 6z"></path></svg>
                                        </button>
                                        <button class="bg-red-500 hover:bg-red-400 p-2 rounded-md text-md" onclick="deleteStaff(${d.user_id})">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="26" height="26" viewBox="0 0 24 24" style="color: rgb(255, 255, 255);"><path fill="currentColor" d="M7 4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2h4a1 1 0 1 1 0 2h-1.069l-.867 12.142A2 2 0 0 1 17.069 22H6.93a2 2 0 0 1-1.995-1.858L4.07 8H3a1 1 0 0 1 0-2h4zm2 2h6V4H9zM6.074 8l.857 12H17.07l.857-12zM10 10a1 1 0 0 1 1 1v6a1 1 0 1 1-2 0v-6a1 1 0 0 1 1-1m4 0a1 1 0 0 1 1 1v6a1 1 0 1 1-2 0v-6a1 1 0 0 1 1-1"></path></svg>
                                        </button>
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

function loadStaffs(){
    fetch('./api/staffs/display.php')
    .then(res => res.json())
    .then(data => {
        renderData(data);
    })
    .catch(err => console.error(err))
}

loadStaffs();

document.getElementById('searchInput').addEventListener('input', (e) => {
    e.preventDefault();

    debouncedSearch(e.target.value);
});

let time;

function debouncedSearch(val){

    clearTimeout(time);

    time = setTimeout(() => {
        fetch(`./api/staffs/display.php?search=${val}`)
        .then(res => res.json())
        .then(data => {
            renderData(data);
        })
        .catch(err => console.error(err))
    }, 1000);

}

function deleteStaff(id){
    Swal.fire({
        icon: 'warning',
        title: 'Are you sure?',
        text: 'This action cannot be undone!',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
        showCancelButton: true,
    }).then((res) => {
        if (res.isConfirmed){
            fetch('./api/staffs/destroy.php', {
                method: 'POST',
                header: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: id })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status == 'success'){
                    Swal.fire({
                        icon: 'success',
                        title: 'Successfully Deleted!',
                        text: 'Account successfully deleted!'
                    })
                    loadStaffs();
                }
                else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Something Went Wrong!',
                        text: data.message
                    })
                }
            })
            .catch(err => console.error(err))
        }
    })
}


document.getElementById('role').addEventListener('change', function(){
    fetch(`./api/staffs/display.php?role=${this.value}`)
    .then(res => res.json())
    .then(data => {
        renderData(data);
    })
    .catch(err => console.error(err))
});

document.getElementById('status').addEventListener('change', function(){
    fetch(`./api/staffs/display.php?status=${this.value}`)
    .then(res => res.json())
    .then(data => {
        renderData(data);
    })
    .catch(err => console.error(err))
});

function openUpdateModal(id){
    document.getElementById('updateModal').classList.remove('hidden');
}

function closeUpdateModal(id){
    document.getElementById('updateModal').classList.add('hidden');
}

function updateStaff(id){
    openUpdateModal();

    fetch(`./api/staffs/get.php?id=${id}`)
    .then(res => res.json())
    .then(data => {
        document.getElementById('acc_id').value = id;
        document.getElementById('update_username').value = data.username;
        document.getElementById('update_role').value = data.role;
        document.getElementById('update_status').value = data.status;
    })
    .catch(err => console.error(err))
}


document.getElementById('updateForm').addEventListener('submit', function(e){
    e.preventDefault();

    fetch('./api/staffs/update.php', {
        method: 'POST',
        body: new FormData(this)
    })
    .then(res => res.json())
    .then(data => {
        if (data.status == 'success'){
            Swal.fire({
                icon: 'success',
                title: 'Successfully Updated!',
                text: 'Account successfully updated!'
            })
            this.reset();
            closeUpdateModal();
            loadStaffs();
        }
        else{
            Swal.fire({
                icon: 'error',
                title: 'Update Failed!',
                text: data.message
            })
        }
    })
    .catch(err => {
        console.error('Error:', err);
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'An error occurred while updating'
        })
    });

});