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

loginForm.addEventListener('submit', (e) => {
    e.preventDefault();

    loginBtn.disabled = true;
    loginBtn.textContent = 'Logging in..';

    try{
        fetch('./api/auth.php', {
            method: 'POST',
            body: new FormData(e.target)
        })
        .then(res => res.json())
        .then(data => {
            if (data.status == 'success' && data.act == 'active'){
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

