function showToast(message, error = true) {
    console.log(message);
    var toastContainer = document.getElementById("toast-container")
    if (toastContainer) {
        toastContainer.textContent = message
        toastContainer.classList.add("show")
        toastContainer.classList.add(error ? "error" : "success")

        setTimeout(function () {
            toastContainer.classList.remove("show")
        }, 3000)
    }
}


async function getDatiCelebrita(id) {
    try {
        const response = await fetch(`../services/getDatiCelebrita.php?id=${id}`);
        const data = await response.json();

        if (data.success) {
            return data.data;
        }
        else {
            throw new Error(data.message)
        }
    }
    catch (error) {
        console.error(error);
    }
}


/*
*  GESTIONE IMMAGINE
*/
async function getNewImage(image) {

    var formData = new FormData();
    formData.append('foto', image);
    formData.append('altezza', 900)
    formData.append('larghezza', 600)

    return fetch('../services/elaboraFoto.php', {
        method: 'POST',
        body: formData,
    })
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            if (data.success) {
                return data.path
            } else {
                throw new Error(data.message);
            }
        })
        .catch(function (error) {
            showToast(error.message);
        });
}

/*
* INIZIALIZZAZIONE PAGINA
*/
document.addEventListener('DOMContentLoaded', async () => {

    var url = window.location.href;
    var id = url.includes('id') ? (new URL(url)).searchParams.get('id') : null;

    var foto = document.getElementById('foto')
    var fotoInput = document.getElementById('fotoInput')
    var nomeInput = document.getElementById('nome')
    var cognomeInput = document.getElementById('cognome')
    var biografiaInput = document.getElementById('descrizione')
    var nascitaInput = document.getElementById('dataNascita')
    var morteInput = document.getElementById('dataMorte')
    var nazionalitaInput = document.getElementById('nazionalita')
    var sessoInput = document.getElementById('sesso')
    const pattern = /^[mfaMFA]$/;

    if (id) {
        var personaggio = await getDatiCelebrita(id)
        nomeInput.value = personaggio.nome
        cognomeInput.value = personaggio.cognome
        biografiaInput.value = personaggio.biografia
        nascitaInput.value = personaggio.data_nascita
        morteInput.value = personaggio.data_morte
        nazionalitaInput.value = personaggio.nazionalita
        sessoInput.value = personaggio.sesso
        foto.src = personaggio.foto
    }

    if (fotoInput) {
        fotoInput.addEventListener('change', async () => {
            foto.setAttribute("src", await getNewImage(fotoInput.files[0]));
        })
    }

    var form = document.getElementById('createForm')
    if (form) {
        form.addEventListener('submit', (event) => {
            event.preventDefault();

            var formData = new FormData();
            var nome = nomeInput.value
            var cognome = cognomeInput.value
            var biografia = biografiaInput.value
            var nascita = nascitaInput.value
            var morte = morteInput.value
            var nazionalita = nazionalitaInput.value
            var sesso = pattern.test(sessoInput.value) ? sessoInput.value : null
            var fotoValue = foto.src != "../../media/addImage.jpg" ? foto.src : '../../media/placeholder.jpg';

            if (nome && cognome && fotoValue && biografia && nascita && nazionalita && sesso) {
                formData.append('nome', nome)
                formData.append('cognome', cognome)
                formData.append('foto', fotoValue)
                formData.append('biografia', biografia)
                formData.append('data_nascita', nascita)
                formData.append('nazionalita', nazionalita)
                formData.append('sesso', sesso)
                if (morte) formData.append('data_morte', morte)
                if (id) formData.append('id', id)

                fetch('../services/creaPersonaggio.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => { return response.json() })
                    .then(response => {
                        if (response.success) {
                            showToast(id ? "Celebrità modificata con successo" : "Celebrità creata con successo", false)
                            setTimeout(function () {
                                url = window.location.href
                                var currentURL = new URL(url);
                                currentURL.pathname = '/MovieMania/code/admin/src/pages/celebrita/celebrita.php';
                                window.location.href = currentURL.href;
                            }, 2000)
                        }
                        else {
                            throw new Error(response.message);
                        }
                    })
                    .catch(error => {
                        showToast("Errore: " + error.message);
                    })
            } else {
                showToast('Inserisci tutti i dati correttamente e riprova!')
            }
        })
    }

    form.addEventListener('reset', event => {
        event.preventDefault();
        url = window.location.href
        var currentURL = new URL(url);
        currentURL.pathname = '/MovieMania/code/admin/src/pages/celebrita/celebrita.php';
        window.location.href = currentURL.href;
    })
})

$(window).off('beforeunload');

window.addEventListener('beforeunload', function (event) {
    event.preventDefault();
    fetch('../services/rimuovi_file.php')
});
