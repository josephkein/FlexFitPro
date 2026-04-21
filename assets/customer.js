function openAddModal() { document.getElementById('addModal').classList.remove('hidden'); }

function closeAddModal() { 
    document.getElementById('addModal').classList.add('hidden'); 
    document.getElementById('customer-form').reset();
}

function renderData(data){
    document.getElementById('membersTable').innerHTML = '';
        data.forEach((d) => {
            let type = d.type == 'student' ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-600';
            let color = d.trainer == null ? 'text-gray-500' : '';
            document.getElementById('membersTable').innerHTML += `
                            <tr>
                                <td class="px-6 py-3">${d.name}</td>
                                <td class="px-6 py-3 flex items-center"><span class="${type} py-1 px-3 rounded-full">${d.type}</span></td>
                                <td class="px-6 py-3">${d.member == null ? 'None' : d.member}</td>
                                <td class="px-6 py-3 ${color}">${d.trainer == null ? 'None' : d.trainer}</td>
                                <td class="px-6 py-3">
                                    <div class="flex gap-2">
                                        <button class="bg-blue-500 p-2 rounded-md text-md" id="update-customer">
                                            <img src="./images/edit.png" alt="">
                                        </button>
                                        <button class="bg-red-500 p-2 rounded-md text-md" id="delete-customer" onclick="deleteCustomer(${d.id})">
                                            <img src="./images/delete.png" alt="">
                                        </button>
                                    </div>
                                </td>
                            </tr>
            `;
        })
        if (data.length < 7) document.getElementById('pagination').classList.add('hidden');
       else document.getElementById('pagination').classList.remove('hidden');
}

function loadCustomers(){
    fetch('./api/customers/display.php')
    .then(res => res.json())
    .then(data => {
        renderData(data);
    })
    .catch(err => console.error(err))
}

loadCustomers();


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
    })
})

document.getElementById('typeFilter').addEventListener('change', function(){
    let val = this.value;

    fetch(`./api/customers/display.php?type=${val}`)
    .then(res => res.json())
    .then(data => {
        renderData(data);
    })

})

document.getElementById('memberFilter').addEventListener('change', function(){
    let val = this.value;

    fetch(`./api/customers/display.php?member=${val}`)
    .then(res => res.json())
    .then(data => {
        renderData(data);
    })

})