/**
 * CAMBIA FOTO
 */
// Verifica se l'elemento <input type="file" id="fotoInput"> esiste
if (document.getElementById('fotoInput')) {
    // Aggiungi un listener per l'evento "change" sull'elemento input
    document.getElementById('fotoInput').addEventListener('change', function () {
        // Crea un oggetto FormData per inviare l'immagine al server
        var formData = new FormData();
        formData.append('foto', this.files[0]);

        // Effettua la chiamata fetch per invocare lo script PHP
        fetch('../service/cambiaFoto.php', {
            method: 'POST',
            body: formData
        })
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                // Interpreta il file JSON ricevuto in risposta
                var success = data.success;
                // Verifica il valore della variabile 'success'
                if (success) {
                    // Ricarica la pagina se 'success' è true
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
                    // Login fallito, mostra il messaggio di errore
                    document.getElementById('login-error-message').style.visibility = 'visible';
                    document.getElementById('login-error-message').textContent = data.message;
                    document.getElementById('password').value = '';
                }
            })
            .catch(error => {
                console.error('Errore durante la richiesta di login:', error);
            });
    });
}

document.getElementById('username');
document.getElementById('password');

if (usernameInput) usernameInput.addEventListener('input', hideErrorMessage1);
if (passwordInput) passwordInput.addEventListener('input', hideErrorMessage1);

function hideErrorMessage1() {
    document.getElementById('login-error-message').style.visibility = 'hidden';
}


/**
 * REGISTRAZIONE
 **/
var signupForm = document.getElementById('signup-form');
if (signupForm) {
    signupForm.addEventListener('submit', function (event) {
        event.preventDefault();

        var nome = document.getElementById('name').value;
        var cognome = document.getElementById('surname').value;
        var username = document.getElementById('username-2').value;
        var email = document.getElementById('email-2').value;
        var password = document.getElementById('password-2').value;
        var repassword = document.getElementById('repassword-2').value;

        if (password !== repassword) {
            document.getElementById('signup-error-message').textContent = 'Le password non corrispondono';
            document.getElementById('signup-error-message').style.visibility = 'visible';
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
                    // Registrazione fallita, mostra il messaggio di errore
                    document.getElementById('signup-error-message').textContent = data.message;
                    document.getElementById('signup-error-message').style.visibility = 'visible';
                }
            })
            .catch(error => {
                console.error('Errore durante la richiesta di registrazione:', error);
            });
    });
}
// Aggiungi event listener agli input per nascondere il messaggio d'errore
var nomeInput = document.getElementById('name');
var cognomeInput = document.getElementById('surname');
var usernameInput = document.getElementById('username-2');
var emailInput = document.getElementById('email-2');
var passwordInput = document.getElementById('password-2');
var repasswordInput = document.getElementById('repassword-2');

if (nomeInput) nomeInput.addEventListener('input', hideErrorMessage2);
if (cognomeInput) cognomeInput.addEventListener('input', hideErrorMessage2);
if (usernameInput) usernameInput.addEventListener('input', hideErrorMessage2);
if (emailInput) emailInput.addEventListener('input', hideErrorMessage2);
if (passwordInput) passwordInput.addEventListener('input', hideErrorMessage2);
if (repasswordInput) repasswordInput.addEventListener('input', hideErrorMessage2);

function hideErrorMessage2() {
    document.getElementById('signup-error-message').style.visibility = 'hidden';
}

/**
 * AGGIORNA DATI UTENTE
 */

var datiForm = document.getElementById('dati-form');
if (datiForm) {
    datiForm.addEventListener('submit', function (event) {
        event.preventDefault();

        var username = document.getElementById('user-username').value;
        var email = document.getElementById('user-email').value;
        var nome = document.getElementById('user-nome').value;
        var cognome = document.getElementById('user-cognome').value;

        fetch('../service/aggiornaUtente.php', {
            method: 'POST',
            body: new URLSearchParams({ username: username, email: email, nome: nome, cognome: cognome })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    console.log(data.message)
                }
            })
            .catch(error => {
                console.error('Errore durante la richiesta di login:', error);
            });
    });
}