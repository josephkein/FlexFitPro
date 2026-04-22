
const logoutBtn = document.getElementById('logout');

logoutBtn.addEventListener('click', (e) => {
    e.preventDefault();

    console.log('hello');

    Swal.fire({
        icon: 'warning',
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, log out!"
    })
    .then((res) => {
        if (res.isConfirmed){
            fetch ('./api/sidebar/logout.php', {
                method: 'POST'
            })
            .then(res => res.json())
            .then(data => {
                if (data.logout == 'success'){
                    Swal.fire({
                        title: "Logged out!",
                        icon: "success"
                    }).then(res => {
                        if (res.isConfirmed){
                            window.location.href = './index.php?url=login';
                        }
                    })
                }
            })
        }
    })
})