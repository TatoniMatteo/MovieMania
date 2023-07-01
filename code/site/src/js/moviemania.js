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
document.getElementById('login-form').addEventListener('submit', function (event) {
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
                // Login riuscito, ricarica la pagina
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
            // Gestisci l'errore in base alle tue esigenze
        });
});

var usernameInput = document.getElementById('username');
var passwordInput = document.getElementById('password');

usernameInput.addEventListener('input', hideErrorMessage);
passwordInput.addEventListener('input', hideErrorMessage);

function hideErrorMessage() {
    document.getElementById('login-error-message').style.visibility = 'hidden';
}


/**
 * REGISTRAZIONE
 **/
document.getElementById('signup-form').addEventListener('submit', function (event) {
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
            // Gestisci l'errore in base alle tue esigenze
        });
});

// Aggiungi event listener agli input per nascondere il messaggio d'errore
var nomeInput = document.getElementById('name');
var cognomeInput = document.getElementById('surname');
var usernameInput = document.getElementById('username-2');
var emailInput = document.getElementById('email-2');
var passwordInput = document.getElementById('password-2');
var repasswordInput = document.getElementById('repassword-2');

nome.addEventListener('input', hideErrorMessage);
cognome.addEventListener('input', hideErrorMessage);
usernameInput.addEventListener('input', hideErrorMessage);
emailInput.addEventListener('input', hideErrorMessage);
passwordInput.addEventListener('input', hideErrorMessage);
repasswordInput.addEventListener('input', hideErrorMessage);

function hideErrorMessage() {
    document.getElementById('signup-error-message').style.visibility = 'hidden';
}