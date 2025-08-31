(function() {
    const authWrapper = document.querySelector('.wrapper')
    const loginLink = document.querySelector('.login-link')
    const registerLink = document.querySelector('.register-link')
    const forgetLink = document.querySelector('.forget-link')
    const loginBack = document.querySelector('.login-back')

    if (authWrapper && registerLink) {
        registerLink.addEventListener('click', ()=> {
            authWrapper.classList.add('active');
        })
    }

    if (authWrapper && loginLink) {
        loginLink.addEventListener('click', ()=> {
            authWrapper.classList.remove('active');
        })
    }

    if (authWrapper && forgetLink) {
        forgetLink.addEventListener('click', ()=>{
            authWrapper.classList.add('activate');
        })
    }

    if (authWrapper && loginBack) {
        loginBack.addEventListener('click', ()=>{
            authWrapper.classList.remove('activate');
        })
    }
})();