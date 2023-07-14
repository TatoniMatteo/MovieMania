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
            alert(error);
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
    var nascitaInput = document.getElementById('data')
    var altezzaInput = document.getElementById('altezza')
    var nazionalitaInput = document.getElementById('nazionalita')

    if (id) {
        var personaggio = await getDatiCelebrita(id)
        nomeInput.value = personaggio.nome
        cognomeInput.value = personaggio.cognome
        biografiaInput.value = personaggio.biografia
        nascitaInput.value = personaggio.data_nascita
        altezzaInput.value = personaggio.altezza
        nazionalitaInput.value = personaggio.nazionalita
        foto.src = personaggio.foto
    }

    if (fotoInput) {
        fotoInput.addEventListener('change', async () => {
            foto.setAttribute("src", await getNewImage(fotoInput.files[0]));
        })
    }

    var submitBtn = document.getElementById('submitBtn')
    if (submitBtn) {
        submitBtn.addEventListener('click', (event) => {
            event.preventDefault();

            var formData = new FormData();
            var nome = nomeInput.value
            var cognome = cognomeInput.value
            var biografia = biografiaInput.value
            var nascita = nascitaInput.value
            var altezza = altezzaInput.value
            var nazionalita = nazionalitaInput.value
            var fotoValue = foto.src != "../../media/addImage.jpg" ? foto.src : '../../media/placeholder.jpg';

            if (nome && cognome && fotoValue && biografia && nascita && nazionalita && altezza) {
                formData.append('nome', nome)
                formData.append('cognome', cognome)
                formData.append('foto', fotoValue)
                formData.append('biografia', biografia)
                formData.append('data_nascita', nascita)
                formData.append('nazionalita', nazionalita)
                formData.append('altezza', altezza)
                if (id) formData.append('id', id)

                fetch('../services/creaPersonaggio.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => { return response.json() })
                    .then(response => {
                        if (response.success) {
                            alert(id ? "Celebrità modificata con successo" : "Celebrità creata con successo")
                            url = window.location.href
                            var currentURL = new URL(url);
                            currentURL.pathname = '/MovieMania/code/admin/src/pages/celebrita/celebrita.php';
                            window.location.href = currentURL.href;
                        }
                        else {
                            throw new Error(response.message);
                        }
                    })
                    .catch(error => {
                        alert("Error: " + error.message);
                    })
            } else {
                alert('Inserisci tutti i dati correttamente e riprova!')
            }
        })
    }

    var exitBtn = document.getElementById('exitBtn')
    if (exitBtn) {
        exitBtn.addEventListener('click', event => {
            event.preventDefault();
            url = window.location.href
            var currentURL = new URL(url);
            currentURL.pathname = '/MovieMania/code/admin/src/pages/celebrita/celebrita.php';
            window.location.href = currentURL.href;
        })
    }
})

$(window).off('beforeunload');

window.addEventListener('beforeunload', function (event) {
    event.preventDefault();
    fetch('../services/rimuovi_file.php')
});
