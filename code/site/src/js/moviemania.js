document.addEventListener('DOMContentLoaded', function () {
    function showToast(message, icon_class) {
        var toastContainer = document.getElementById("toast-container");
        console.log(toastContainer);
        if (toastContainer) {
            toastContainer.textContent = message;
            toastContainer.classList.add("show");

            var iconCircle = document.createElement("span");
            iconCircle.classList.add("icon-circle");

            var icon = document.createElement("i");
            icon.classList.add(icon_class);
            iconCircle.appendChild(icon);

            toastContainer.appendChild(iconCircle);

            setTimeout(function () {
                toastContainer.classList.remove("show");
            }, 3000);
        }
    }



    function hideErrorMessage(elemento) {
        var element = document.getElementById(elemento);
        if (element) {
            element.style.visibility = 'hidden';
        }
    }

    async function goToReview(rate) {
        if (await checkAuth()) {
            var url = window.location.href;

            var urlParams = new URLSearchParams(url.substring(url.indexOf('?')));
            var id_programma = urlParams.get('id');
            if (id_programma.includes('#')) {
                id_programma = id_programma.split('#')[0];
            }

            // Determinare se si tratta di un film o una serie
            var isFilm = url.includes('moviesingle.php');
            var isSerie = url.includes('seriessingle.php');

            var tipo = null;
            if (isFilm) { tipo = 'film' }
            else if (isSerie) { tipo = 'serie' }

            var currentURL = new URL(url);
            currentURL.pathname = '/MovieMania/code/site/src/pages/review/review.php';

            currentURL.search = '?id=' + id_programma + '&tipo=' + tipo + (rate != null ? '&rate=' + rate : '');
            window.location.href = currentURL.href;
        }
        else {

            var loginct = $("#login-content");
            var loginWrap = $(".login-wrapper");
            var overlay = $(".overlay");
            loginWrap.each(function () {
                $(this).wrap('<div class="overlay"></div>')
            });
            loginct.parents(overlay).addClass("openform");
            $(document).on('click', function (e) {
                var target = $(e.target);
                if ($(target).hasClass("overlay")) {
                    $(target).find(loginct).each(function () {
                        $(this).removeClass("openform");
                    });
                    setTimeout(function () {
                        $(target).removeClass("openform");
                    }, 350);
                }
            });
        }
    }

    async function checkAuth() {
        return fetch('../service/checkauth.php')
            .then(response => response.json())
            .then(data => {
                return data.loggedIn
            })
            .catch(error => {
                console.error('Errore durante la verifica dell\'autenticazione:', error);
                return false;
            });
    }


    recensioneBtn = document.getElementById("recensione");
    if (recensioneBtn) {
        recensioneBtn.addEventListener('click', function (event) {
            goToReview(null)
        })
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
            goToReview(rating)
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
     * STELLE RECENSIONE
     **/
    const review_stars = document.querySelectorAll('.review-star');

    review_stars.forEach(star => {
        star.addEventListener('click', function () {
            const rating = parseInt(this.getAttribute('data-rating'));
            for (let i = 1; i <= review_stars.length; i++) {
                if (i <= rating) {
                    review_stars[i - 1].classList.remove('ion-ios-star-outline');
                    review_stars[i - 1].classList.add('ion-ios-star');
                } else {
                    review_stars[i - 1].classList.remove('ion-ios-star');
                    review_stars[i - 1].classList.add('ion-ios-star-outline');
                }
            }
        });
    });


    /**
     * SALVA RECENSIONE
     */
    var reviewForm = document.getElementById('review-form');
    if (reviewForm) {
        reviewForm.addEventListener('submit', function (event) {
            event.preventDefault();

            var errorLabel = document.getElementById('review-error');
            var titolo = document.getElementById('titolo-review').value;
            var descrizione = document.getElementById('descrizione-review').value;
            var voto = 0
            review_stars.forEach(star => {
                if (star.classList.contains('ion-ios-star')) voto++
            })
            var url = window.location.href;
            var urlParams = new URLSearchParams(url.substring(url.indexOf('?')));
            var id_programma = urlParams.get('id');
            var tipo = urlParams.get('tipo');

            fetch('../service/aggiornaRecensione.php', {
                method: 'POST',
                body: new URLSearchParams({ voto: voto, titolo: titolo, descrizione: descrizione, id_programma: id_programma, tipo: tipo })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        var currentURL = new URL(url);
                        if (tipo == 'film')
                            currentURL.pathname = '/MovieMania/code/site/src/pages/moviesingle/moviesingle.php';
                        else
                            currentURL.pathname = '/MovieMania/code/site/src/pages/seriessingle/seriessingle.php';

                        currentURL.search = '?id=' + id_programma;
                        window.location.href = currentURL.href;
                    } else {
                        throw new Error(data.message)
                    }
                })
                .catch(error => {
                    errorLabel.textContent = error.message
                    errorLabel.style.visibility = 'visible'
                });
        });
        reviewForm.addEventListener('reset', function (event) {
            var url = window.location.href;
            var urlParams = new URLSearchParams(url.substring(url.indexOf('?')));
            var id_programma = urlParams.get('id');
            var tipo = urlParams.get('tipo');

            var currentURL = new URL(url);
            if (tipo == 'film')
                currentURL.pathname = '/MovieMania/code/site/src/pages/moviesingle/moviesingle.php';
            else
                currentURL.pathname = '/MovieMania/code/site/src/pages/seriessingle/seriessingle.php';

            currentURL.search = '?id=' + id_programma;
            window.location.href = currentURL.href;
        });
        var textInputs = reviewForm.querySelectorAll('input[type="text"], textarea');
        textInputs.forEach(input => {
            input.addEventListener('input', function handleInput(event) {
                hideErrorMessage('review-error');
            });
        });
    }

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


    /**
     * FANCYBOX
     */

    var trailerLink = document.getElementById("trailer");

    if (trailerLink) {
        trailerLink.addEventListener("click", function (event) {
            event.preventDefault();

            var src = this.getAttribute("href");

            if (src) {
                var options = {
                    type: "iframe",
                    iframe: {
                        preload: false
                    }
                };

                Fancybox.open(src, options);
            }
        });
    }


    /**
    *   PREFERITI
    */

    var preferitiBtn = document.getElementById("preferiti");

    if (preferitiBtn) {
        var url = window.location.href;

        var urlParams = new URLSearchParams(url.substring(url.indexOf('?')));
        var id_programma = urlParams.get('id');
        if (id_programma.includes('#')) {
            id_programma = id_programma.split('#')[0];
        }

        // Determinare se si tratta di un film o una serie
        var isFilm = url.includes('moviesingle.php');
        var isSerie = url.includes('seriessingle.php');

        var tipo = null;
        if (isFilm) { tipo = 'film' }
        else if (isSerie) { tipo = 'serie' }

        preferitiBtn.addEventListener('click', function (event) {
            event.preventDefault();
            fetch('../service/aggiornaPreferito.php', {
                method: 'POST',
                body: new URLSearchParams({ id_programma: id_programma, tipo: tipo })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        var icona = document.createElement("i");
                        icona.setAttribute("class", data.preferito ? "ion-android-remove" : "ion-heart");
                        var testoLink = document.createTextNode(data.preferito ? "Rimuovi dai preferiti" : "Aggiungi ai preferiti");
                        this.textContent = ""
                        this.appendChild(icona);
                        this.appendChild(testoLink);
                        showToast(data.preferito ? "Programma aggiunto ai preferiti!" : "Programma rimosso dai preferiti!", data.preferito ? "ion-heart" : "ion-android-remove");
                    } else {
                        throw new Error(data.message)
                    }
                })
                .catch(error => {
                    console.error(error.message)
                });
        });
    }
});