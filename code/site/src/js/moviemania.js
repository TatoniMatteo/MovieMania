function hideErrorMessage(elemento) {
    var element = document.getElementById(elemento);
    if (element) {
        element.style.visibility = 'hidden';
    }
}

/**
 * CAMBIA FOTO
 */
if (document.getElementById('fotoInput')) {
    document.getElementById('fotoInput').addEventListener('change', function () {

        var formData = new FormData();
        formData.append('foto', this.files[0]);

        fetch('../service/cambiaFoto.php', {
            method: 'POST',
            body: formData
        })
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                if (data.success) {
                    window.location.reload();
                } else {
                    throw new Error(data.message);
                }
            })
            .catch(function (error) {
                alert(error);
            });
    });
}


/**
 * MODIFICA STELLE
 **/
const stars = document.querySelectorAll('.editable-star');

stars.forEach(star => {
    star.addEventListener('click', function () {
        const rating = parseInt(this.getAttribute('data-rating'));
        window.location.href = "#";
    });

    star.addEventListener('mouseover', function () {
        console.log('over');
        const rating = parseInt(this.getAttribute('data-rating'));

        for (let i = 1; i <= stars.length; i++) {
            if (i <= rating) {
                stars[i - 1].classList.remove('ion-ios-star-outline');
                stars[i - 1].classList.add('ion-ios-star');
            } else {
                stars[i - 1].classList.remove('ion-ios-star');
                stars[i - 1].classList.add('ion-ios-star-outline');
            }
        }
    });
});


/**
 * LOGIN
 **/
var loginForm = document.getElementById('login-form');
if (loginForm) {
    loginForm.addEventListener('submit', function (event) {
        event.preventDefault();

        var errorLabel = document.getElementById('login-error-message');
        var username = document.getElementById('username').value;
        var password = document.getElementById('password').value;

        fetch('../service/login.php', {
            method: 'POST',
            body: new URLSearchParams({ username: username, password: password })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    throw new Error(data.message);
                }
            })
            .catch(error => {
                errorLabel.style.visibility = 'visible';
                errorLabel.textContent = error.message;
            });
    });

    var textInputs = loginForm.querySelectorAll('input[type="text"]');
    textInputs.forEach(input => {
        input.addEventListener('input', function handleInput(event) {
            hideErrorMessage('login-error-message');
        });
    });
}

/**
 * REGISTRAZIONE
 **/
var signupForm = document.getElementById('signup-form');
if (signupForm) {
    signupForm.addEventListener('submit', function (event) {
        event.preventDefault();

        var errorLabel = document.getElementById('signup-error-message')
        var nome = document.getElementById('name').value;
        var cognome = document.getElementById('surname').value;
        var username = document.getElementById('username-2').value;
        var email = document.getElementById('email-2').value;
        var password = document.getElementById('password-2').value;
        var repassword = document.getElementById('repassword-2').value;

        if (password !== repassword) {
            errorLabel.textContent = 'Le password non corrispondono';
            errorLabel.style.visibility = 'visible';
            return;
        }

        fetch('../service/signup.php', {
            method: 'POST',
            body: new URLSearchParams({ nome: nome, cognome: cognome, username: username, email: email, password: password })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Registrazione riuscita
                    window.location.reload();
                } else {
                    throw new Error(data.message);
                }
            })
            .catch(error => {
                errorLabel.textContent = error.message;
                errorLabel.style.visibility = 'visible';
            });
    });

    var textInputs = signupForm.querySelectorAll('input[type="text"]');
    textInputs.forEach(input => {
        input.addEventListener('input', function handleInput(event) {
            hideErrorMessage('signup-error-message');
        });
    });
}
/**
 * AGGIORNA DATI UTENTE
 */
var datiForm = document.getElementById('dati-form');
if (datiForm) {
    datiForm.addEventListener('submit', function (event) {
        event.preventDefault();

        var errorLabel = document.getElementById('dati-error')
        var username = document.getElementById('user-username').value
        var email = document.getElementById('user-email').value
        var nome = document.getElementById('user-nome').value
        var cognome = document.getElementById('user-cognome').value

        fetch('../service/aggiornaUtente.php', {
            method: 'POST',
            body: new URLSearchParams({ username: username, email: email, nome: nome, cognome: cognome })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    throw new Error(data.message)
                }
            })
            .catch(error => {
                errorLabel.textContent = error.message
                errorLabel.style.visibility = 'visible'
            });
    });

    var textInputs = datiForm.querySelectorAll('input[type="text"]');
    textInputs.forEach(input => {
        input.addEventListener('input', function handleInput(event) {
            hideErrorMessage('dati-error');
        });
    });
}

/**
 * AGGIORNA PASSWORD
 */
var passwordForm = document.getElementById('password-form');
if (passwordForm) {
    passwordForm.addEventListener('submit', function (event) {
        event.preventDefault();

        var errorLabel = document.getElementById('password-error');
        var vecchia = document.getElementById('old').value;
        var nuova = document.getElementById('new').value;
        var retype = document.getElementById('retype').value;

        fetch('../service/aggiornaPassword.php', {
            method: 'POST',
            body: new URLSearchParams({ old: vecchia, new: nuova, retype: retype })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    throw new Error(data.message)
                }
            })
            .catch(error => {
                errorLabel.textContent = error.message
                errorLabel.style.visibility = 'visible'
            });
    });
    var textInputs = passwordForm.querySelectorAll('input[type="password"]');
    textInputs.forEach(input => {
        input.addEventListener('input', function handleInput(event) {
            hideErrorMessage('password-error');
        });
    });
}
