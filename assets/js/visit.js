
let page = 1;

const next = document.getElementById('next');
const prev = document.getElementById('prev');
// Pagination
next.addEventListener('click', (e) => {
    e.preventDefault();

    page++;
    fetch(`./api/visits/display.php?page=${page}`)
    .then(res => res.json())
    .then(data => {
        document.getElementById('page').textContent = page;
        renderData(data);
    })
})

prev.addEventListener('click', (e) => {
    e.preventDefault();

    page--;
    fetch(`./api/visits/display.php?page=${page}`)
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

    document.getElementById('visitTable').innerHTML = '';
        data.forEach((d) => {

            document.getElementById('visitTable').innerHTML += `
                            <tr>
                                <td class="px-6 py-3">${d.date}</td>
                                <td class="px-6 py-3">${d.customer}</td>
                                <td class="px-6 py-3">${d.type}</td>
                                <td class="px-6 py-3">${d.staff}</td>
                                <td class="px-6 py-3">
                                    <div class="flex gap-2">
                                        <button class="bg-red-500 p-2 rounded-md text-md">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="26" height="26" viewBox="0 0 24 24" style="color: rgb(255, 255, 255);"><path fill="currentColor" d="M7 4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2h4a1 1 0 1 1 0 2h-1.069l-.867 12.142A2 2 0 0 1 17.069 22H6.93a2 2 0 0 1-1.995-1.858L4.07 8H3a1 1 0 0 1 0-2h4zm2 2h6V4H9zM6.074 8l.857 12H17.07l.857-12zM10 10a1 1 0 0 1 1 1v6a1 1 0 1 1-2 0v-6a1 1 0 0 1 1-1m4 0a1 1 0 0 1 1 1v6a1 1 0 1 1-2 0v-6a1 1 0 0 1 1-1"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
            `;
        })
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


// Load customers in table
function loadVisits(){
    fetch('./api/visits/display.php')
    .then(res => res.json())
    .then(data => {
        renderData(data);
    })
    .catch(err => console.error(err))
}

loadVisits();


// Filter customer by type
document.getElementById('dateFilter').addEventListener('change', function(){
    let val = this.value;

    fetch(`./api/visits/display.php?date=${val}`)
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
        fetch(`./api/visits/display.php?search=${text}`)
        .then(res => res.json())
        .then(data => {
            renderData(data);
        })
    }, 1000)
}

// Delete customer
function deleteVisits(id){
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
            fetch ('./api/visits/destroy.php', {
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
                        text: "Visit successfully deleted!",
                        icon: "success"
                    })
                    loadVisits();
                }
            })
        }
    })
    
}

