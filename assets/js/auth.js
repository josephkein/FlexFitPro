function showPass(){
            const pass = document.getElementById('pass');

            if (pass.type == 'text'){
                pass.type = 'password';
            }else{
                pass.type = 'text';
            }
}

const loginForm = document.getElementById('login');
const loginBtn = document.getElementById('loginBtn');
const user = d


loginForm.addEventListener('submit', (e) => {
    e.preventDefault();

    loginBtn.disabled = true;
    loginBtn.textContent = 'Logging in..';

    const outline = 'focus:outline-violet-500';
    const error_out = 'border-red-500 focus:outline-red-400';


    try{
        fetch('./api/auth.php', {
            method: 'POST',
            body: new FormData(e.target)
        })
        .then(res => res.json())
        .then(data => {
            if (data.status == 'success'){
                Swal.fire({
                    icon:'success',
                    title:'Success!',
                    text:'Log in successfully'
                }).then(res => {
                    if (res.isConfirmed){
                        if (data.role == 'admin') window.location.href = './index.php?url=admin';
                        else window.location.href = './index.php?url=staff';
                    }
                })
            }
            else{
                const err = document.getElementById('error-head');
                
                err.classList.remove('hidden');
                err.textContent = data.message;
            }
        })
    }
    catch(err){
        console.log(err);
    }
    finally{
        loginBtn.disabled = false;
        loginBtn.textContent = 'Sign in';
    }

})

