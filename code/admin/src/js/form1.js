function showToast(message, error = true) {
    var toastContainer = document.getElementById("toast-container")
    if (toastContainer) {
        toastContainer.textContent = message
        toastContainer.classList.add("show")
        toastContainer.classList.add(error ? "error-toast" : "success-toast")
        setTimeout(function () {
            toastContainer.classList.remove("show")
            toastContainer.classList.remove("error-toast")
            toastContainer.classList.remove("success-toast")
        }, 3000)
    }
}

/*
* GET PERSONAGGI
*/
async function getPersonaggi() {
    try {
        const response = await fetch("../services/getPersonaggi.php");
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
* GET RUOLI
*/
async function getRuoli() {
    try {
        const response = await fetch(`../services/getRuoli.php`);
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
* GET DATI PROGRAMMA
*/
async function getDatiProgramma(id, tipo) {
    try {
        const response = await fetch(`../services/getDatiProgramma.php?id=${id}&tipo=${tipo}`);
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
* PERSONAGGI DEL PROGRAMMA
*/
async function getPersonaggiProgramma(id, tipo) {
    try {
        const response = await fetch(`../services/getDatiPersonaggi.php?id=${id}&tipo=${tipo}`);
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
* CATEGORIE DEL PROGRAMMA
*/
async function getCategorieProgramma(id, tipo) {
    try {
        const response = await fetch(`../services/getDatiCategorie.php?id=${id}&tipo=${tipo}`);
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
* STAGIONI DELLA SERIE
*/
async function getStagioniSerie(id) {
    try {
        const response = await fetch(`../services/getDatiStagione.php?id=${id}`);
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
* FILTRA PERSONAGGI
*/
function filter(filtro, personaggio) {
    filtro = filtro.toUpperCase()
    personaggio = personaggio.toUpperCase()
    return personaggio.includes(filtro)
}


/*
*  CREA DIV
*/
function createDiv(row, align, elements, margin = 10, size = 3) {
    var div = document.createElement('div')
    if (row) div.classList.add('row')
    else {
        div.classList.add('col')
        div.classList.add(`col-md-${size}`)
        div.style.marginBottom = margin + 'px'
    }
    if (align) div.classList.add(align)
    div.classList.add("align-middle")
    div.style.height = "100%"
    elements.forEach(element => div.appendChild(element))

    return div
}


/*
*  CREA MENU A DISCESA
*/
function createSelect(categoria, ruoli, defaultValue) {
    var select = document.createElement('select')
    select.setAttribute('id', 'ruolo')
    select.classList.add('form-control')

    ruoli.forEach(ruolo => {
        if (ruolo.categoria === categoria) {
            if (!defaultValue) defaultValue = ruolo.id
            var option = document.createElement('option')
            option.textContent = ruolo.ruolo
            option.value = ruolo.id
            select.appendChild(option)
        }
    })

    select.value = defaultValue
    return select
}


/*
* CREA PULASNTE STAR
*/
function createCheckbox(defaultValue = false) {

    var labelStar = document.createElement("label")
    labelStar.classList.add("form-check-label")
    labelStar.setAttribute("for", "checkbox")
    labelStar.textContent = "STAR"
    labelStar.style.marginRight = "10px"


    var label = document.createElement("label")
    label.classList.add("switch")
    label.classList.add("switch-text")
    label.classList.add("switch-warning")

    var checkbox = document.createElement("input")
    checkbox.setAttribute("type", "checkbox")
    checkbox.setAttribute("id", "checkbox")
    checkbox.classList.add("switch-input")

    if (defaultValue)
        checkbox.setAttribute("checked", "checked")

    var span1 = document.createElement("span")
    span1.setAttribute("data-on", "SI")
    span1.setAttribute("data-off", "NO")
    span1.classList.add("switch-label")

    var span2 = document.createElement("span")
    span2.classList.add("switch-handle")

    label.appendChild(checkbox)
    label.appendChild(span1)
    label.appendChild(span2)

    return createDiv(false, "text-center", [labelStar, label], 0, 2)


}


/*
* CREA CAMPO INTERPRETA
*/
function createInputText(text = null) {

    var textinput = document.createElement("input")
    textinput.classList.add("form-control");
    textinput.setAttribute("type", "text");
    textinput.setAttribute("placeholder", "interpreta");
    if (text) textinput.setAttribute("value", text)
    textinput.setAttribute("id", "interpreta")

    var div = createDiv(false, "text-center", [textinput])
    return div
}


/*
*  CREA PULSANTE ELIMINA
*/
function createDelButton() {
    btn = document.createElement("a")
    btn.addEventListener("click", elimina)
    btn.setAttribute("cursor", "pointer")
    btn.classList.add("btn")
    icon = document.createElement("i")
    icon.classList.add("fas")
    icon.classList.add("fa-trash")
    btn.appendChild(icon)
    return createDiv(false, "text-center", [btn], null, 1)
}

function elimina() {

    var element = this
    if (element && element.parentElement && element.parentElement.parentElement) {
        var nonno = element.parentElement.parentElement
        nonno.parentNode.removeChild(nonno)
    }
}


/*
*  COPERTINA
*/
function createCopertina(id, copertina = "../../media/addImage.jpg") {
    var label = document.createElement("label")
    label.setAttribute("for", `copertinaInput ${id}`)

    var image = document.createElement("img")
    image.src = copertina
    image.setAttribute("style", "aspect-ratio 2/3;")

    label.appendChild(image)

    var fileLoader = document.createElement("input")
    fileLoader.type = "file"
    fileLoader.setAttribute("id", `copertinaInput ${id}`)
    fileLoader.style.display = "none"
    fileLoader.setAttribute("accept", ".jpg, .jpeg, .png")
    fileLoader.classList.add("form-control-file")
    fileLoader.addEventListener('change', async () => {
        image.setAttribute("src", await getNewImage(fileLoader.files[0], 390, 260));
    })

    return createDiv(false, "text-center", [label, fileLoader])
}

/*
*  INPUT NUMERICO
*/
function createInputNumerico(value, placeholder) {
    label = document.createElement("label")
    label.setAttribute("for", "input")
    label.innerHTML = placeholder

    var input = document.createElement("input")
    input.setAttribute("type", "number")
    input.classList.add("form-control")
    input.setAttribute("placeholder", placeholder)
    input.setAttribute("min", 1)

    if (value) input.value = value

    return createDiv(true, "text-center", [label, input])
}

/*
*  DATA PUBBLICAZIONE
*/
function createDataPubblicazione(data) {
    label = document.createElement("label")
    label.setAttribute("for", "data")
    label.innerHTML = "Data pubblicazione"

    var dataInput = document.createElement("input")
    dataInput.setAttribute("type", "date")
    dataInput.classList.add("form-control")

    if (data) dataInput.value = data

    return createDiv(true, "text-center", [label, dataInput])
}

/*
*  AGGIUGNI PRODUTTORE
*/
function addProduttore(nome, id, star, ruolo, ruoli) {
    var produttori = document.getElementById('produttori')

    var space = createDiv(false, "text-left", []);

    var btnElimina = createDelButton()

    var labelNome = document.createElement("label")
    labelNome.innerHTML = nome
    labelNome.classList.add("form-control-label")
    labelNome.setAttribute("id", 'nome')
    var divNome = createDiv(false, "text-left", [labelNome]);

    var roleSelect = createSelect(1, ruoli, ruolo)
    var divRole = createDiv(false, "text-center", [roleSelect])

    var divStar = createCheckbox(star)

    var produttore = createDiv(true, null, [space, btnElimina, divNome, divRole, divStar]);
    produttore.setAttribute("id", id)

    produttori.appendChild(produttore)
}


/*
*  AGGIUGNI ATTORE
*/
function addAttore(nome, id, star, ruolo) {
    var attori = document.getElementById('attori');

    var space = createDiv(false, "text-left", []);

    var btnElimina = createDelButton()

    var labelNome = document.createElement("label")
    labelNome.innerHTML = nome
    labelNome.classList.add("form-control-label")
    labelNome.setAttribute("id", 'nome')
    var divNome = createDiv(false, "text-left", [labelNome]);

    var divStar = createCheckbox(star)

    var divInterpreta = createInputText(ruolo)

    var attore = createDiv(true, null, [space, btnElimina, divNome, divInterpreta, divStar]);
    attore.setAttribute("id", id)
    attori.appendChild(attore);
}

/*
*  AGGIUNGI MEMBRO DELLA TROUPE
*/
function addMembro(nome, id, star, ruolo, ruoli) {
    var membri = document.getElementById('troupe')

    var space = createDiv(false, "text-left", []);

    var btnElimina = createDelButton()

    var labelNome = document.createElement("label")
    labelNome.innerHTML = nome
    labelNome.classList.add("form-control-label")
    labelNome.setAttribute("id", 'nome')
    var divNome = createDiv(false, "text-left", [labelNome]);

    var roleSelect = createSelect(3, ruoli, ruolo)
    var divRole = createDiv(false, "text-center", [roleSelect])

    var divStar = createCheckbox(star)

    var membro = createDiv(true, null, [space, btnElimina, divNome, divRole, divStar]);
    membro.setAttribute("id", id)

    membri.appendChild(membro)
}

/*
*  AGGIUNGI STAGIONE
*/
function addStagione(copertina, numero, pubblicazione, episodi) {
    var stagioni = document.getElementById("stagioni")
    const ultimaStagione = stagioni.lastElementChild;
    var id = ultimaStagione ? ultimaStagione.id : ''
    id = id.length > 0 ? parseInt(id) + 1 : 0

    var space = createDiv(false, "text-left", [])
    var deleteBtn = createDelButton()
    var image = createCopertina(id, copertina)

    var slotNumero = createInputNumerico(numero, "Numero stagione")
    var slotData = createDataPubblicazione(pubblicazione)
    var slotEpisodi = createInputNumerico(episodi, "Numero episodi")

    var slotDati = createDiv(false, "text-left", [slotNumero, slotData, slotEpisodi], null, 5)
    slotData.setAttribute("style", "padding-right: 20px; margin-bottom:20px;")
    slotNumero.setAttribute("style", "padding-right: 20px; margin-bottom:20px;")
    slotEpisodi.setAttribute("style", "padding-right: 20px")

    var stagione = createDiv(true, null, [space, deleteBtn, image, slotDati]);
    stagione.setAttribute("style", "margin-bottom:30px;")
    stagione.setAttribute("id", id)
    stagioni.appendChild(stagione)
}


/*
*  GESTIONE IMMAGINE
*/
async function getNewImage(image, altezza, larghezza) {

    var formData = new FormData();
    formData.append('foto', image);
    formData.append('altezza', altezza)
    formData.append('larghezza', larghezza)

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
*  GESTIONE LINK YOUTUBE
*/
function trasformaURL(url) {
    var embedUrl = "https://www.youtube.com/embed/";
    if (url.includes(embedUrl)) {
        return url;
    }
    if (url.includes("youtu.be/")) {
        var videoId = url.split("youtu.be/")[1];
        return embedUrl + videoId;
    }
    if (url.includes("youtube.com/watch?v=")) {
        var videoId = url.split("youtube.com/watch?v=")[1];
        var ampersandIndex = videoId.indexOf("&")
        if (ampersandIndex !== -1) {
            videoId = videoId.substring(0, ampersandIndex);
        }
        return embedUrl + videoId;
    }
    if (url.includes("youtube.com/watch?") && url.includes("&ab_channel=")) {
        var videoParams = url.split("youtube.com/watch?")[1];
        var ampersandIndex = videoParams.indexOf("&");
        if (ampersandIndex !== -1) {
            videoParams = videoParams.substring(0, ampersandIndex);
        }
        return embedUrl + videoParams;
    }
    return url;
}

/*
* CREA RICERCA PERSONAGGIO
*/
function createDropdownMenu(personaggioInput, menuId, addFunction, addParams) {
    var menu = document.getElementById(menuId);
    var options;

    personaggioInput.addEventListener('keyup', () => {
        var filtro = personaggioInput.value;

        if (!menu.firstElementChild) {
            data.forEach(element => {
                var option = document.createElement('option');
                option.innerHTML = element.nome + " " + element.cognome;
                option.classList.add('dropdown-item');
                option.value = element.id;
                menu.appendChild(option);
            });

            options = menu.getElementsByTagName('option');
            for (let option of options) {
                option.addEventListener('click', function (event) {
                    addFunction(option.innerHTML, option.value, ...addParams);
                    personaggioInput.value = "";
                });
            }
        }

        var limite = 5;
        var count = 0;
        for (let element of options) {
            if (filtro && filter(filtro, element.innerHTML) && count < limite) {
                element.style.display = '';
                count++;
            } else {
                element.style.display = 'none';
            }
        }
    });
}


/*
* INIZIALIZZAZIONE PAGINA
*/
document.addEventListener('DOMContentLoaded', async () => {

    var url = window.location.href;
    var isFilm = url.includes('film');
    var isSerie = url.includes('serie');
    var id = url.includes('id') ? (new URL(url)).searchParams.get('id') : null;
    var ruoli = await getRuoli();

    var personaggi1 = document.getElementById('personaggi1')
    var personaggi2 = document.getElementById('personaggi2')
    var personaggi3 = document.getElementById('personaggi3')

    data = await getPersonaggi()

    if (personaggi1) createDropdownMenu(personaggi1, 'dropdown-menu1', addProduttore, [false, 0, ruoli]);

    if (personaggi2) createDropdownMenu(personaggi2, 'dropdown-menu2', addAttore, [false, ""]);

    if (personaggi3) createDropdownMenu(personaggi3, 'dropdown-menu3', addMembro, [false, 0, ruoli]);

    var trailerLink = document.getElementById('trailerLink')
    var trailer = document.getElementById('trailer')
    var trailerBtn = document.getElementById('trailerBtn')

    if (trailer && trailerLink && trailerBtn) {
        trailerLink.addEventListener('change', () => {
            url = trailerLink.value
            url = trasformaURL(url)
            trailer.setAttribute('src', url ? url : 'placeholder.html');
            trailerLink.value = url;
        })
        trailerBtn.addEventListener('click', event => {
            url = trailerLink.value
            url = trasformaURL(url)
            trailer.setAttribute('src', url ? url : 'placeholder.html');
            trailerLink.value = url;
        })
    }

    var copertina = document.getElementById('copertina')
    var fileLoader = document.getElementById('fotoInput')
    var titolo = document.getElementById('titolo')
    var descrizione = document.getElementById('descrizione')
    var pubblicazione = document.getElementById('data')
    var durata = document.getElementById('durata')
    var completata = document.getElementById('completata')


    if (fileLoader && copertina) {
        fileLoader.addEventListener('change', async () => {
            copertina.setAttribute("src", await getNewImage(fileLoader.files[0], 437, 285));
        })
    }
    var categorieBox = document.getElementById('selectBox')
    if (categorieBox) {
        categorieBox.addEventListener('change', event => {
            event.preventDefault();
            var selectedValues = Array.from(categorieBox.selectedOptions).map(option => option.value);
            selectedValues.forEach(value => {
                selectCategory(value)
            });
        })
    }

    function selectCategory(value) {
        var selectedOptions = document.getElementById('selectedOptions');
        var selectBox = document.getElementById('selectBox');
        var option = selectBox.querySelector('option[value="' + value + '"]');
        option.style.display = 'none';
        var optionDiv = document.createElement('div');
        optionDiv.textContent = option.innerHTML;
        optionDiv.className = 'option';
        optionDiv.setAttribute('id', option.value);
        optionDiv.style = "height: 30px;"
        var removeDiv = document.createElement('div');
        var icon = document.createElement('i')
        icon.classList.add('fas')
        icon.classList.add('fa-close')
        removeDiv.appendChild(icon);
        removeDiv.className = 'remove';
        removeDiv.onclick = function () {
            selectedOptions.removeChild(optionDiv);
            option.style.display = 'block';
        };
        optionDiv.appendChild(removeDiv);
        selectedOptions.appendChild(optionDiv);

    }
    if (isSerie) {
        document.getElementById('addStagione').addEventListener('click', event => {
            event.preventDefault();
            addStagione()
        })
    }

    if (id) {
        var programma = await getDatiProgramma(id, isFilm ? 'film' : 'serie')
        var personaggi = await getPersonaggiProgramma(id, isFilm ? 'film' : 'serie')
        var categorie = await getCategorieProgramma(id, isFilm ? 'film' : 'serie')
        var stagioni = null
        if (isSerie) stagioni = await getStagioniSerie(id)

        copertina.setAttribute("src", programma.copertina)
        titolo.value = programma.titolo
        descrizione.value = programma.descrizione
        if (isFilm) pubblicazione.value = programma.data_pubblicazione
        if (isFilm) durata.value = programma.durata
        trailer.setAttribute('src', programma.trailer == "https://www.youtube.com/embed/JuLxRYMjx9w" ? "" : programma.trailer)
        trailerLink.value = programma.trailer
        if (isSerie) completata.checked = programma.conclusa

        if (personaggi) {
            personaggi.forEach(personaggio => {
                if (personaggio.categoria_ruolo == 2) {
                    addAttore(
                        personaggio.nome + ' ' + personaggio.cognome,
                        personaggio.id,
                        personaggio.star,
                        personaggio.interpreta
                    )
                }
                else if (personaggio.categoria_ruolo == 1) {
                    addProduttore(
                        personaggio.nome + ' ' + personaggio.cognome,
                        personaggio.id,
                        personaggio.star,
                        personaggio.ruolo,
                        ruoli
                    )
                }
                else {
                    addMembro(
                        personaggio.nome + ' ' + personaggio.cognome,
                        personaggio.id,
                        personaggio.star,
                        personaggio.ruolo,
                        ruoli
                    )
                }
            })
        }

        if (categorie) {
            var selectBox = document.getElementById('selectBox');
            categorie.forEach(categoria => {
                var options = Array.from(selectBox.options)
                options.find(c => c.value == categoria.id_categoria).selected = true;
                selectCategory(categoria.id_categoria)
            });
        }

        if (stagioni) {
            stagioni.forEach(stagione => addStagione(
                stagione.copertina,
                stagione.numero_stagione,
                stagione.data_pubblicazione,
                stagione.episodi,
            ))
        }
    }

    var form = document.getElementById('createForm')
    if (form) {
        form.addEventListener('submit', (event) => {
            event.preventDefault();

            var copertina = document.getElementById('copertina')
            var formData = new FormData();
            var titoloProgramma = titolo.value
            var descrizioneProgramma = descrizione.value
            var copertinaProgramma = copertina.src != "http://localhost/MovieMania/code/admin/src/media/addImage.jpg" ? copertina.src : "http://localhost/MovieMania/code/admin/src/media/noCopertina.jpg";
            var trailerProgramma = trailerLink.value
            if (!trailerProgramma) trailerProgramma = "https://www.youtube.com/embed/JuLxRYMjx9w"
            var durataFilm = null
            var dataFilm = null
            var serieFinita = null
            if (isFilm) {
                durataFilm = durata.value
                dataFilm = pubblicazione.value
            } else {
                serieFinita = completata.checked
            }

            var produttoriElm = document.getElementById('produttori').children
            var produttori = []

            for (let elem of produttoriElm) {
                var pers = elem.getAttribute('id')
                var ruolo = elem.children[3].children[0].value
                var star = elem.children[4].children[1].children[0].checked
                produttori.push({ 'personaggio': pers, 'ruolo': ruolo, 'star': star })
            }

            var attoriElm = document.getElementById('attori').children
            var attori = []

            for (let elem of attoriElm) {
                var pers = elem.getAttribute('id')
                var interpreta = elem.children[3].children[0].value
                var star = elem.children[4].children[1].children[0].checked
                attori.push({ 'personaggio': pers, 'interpreta': interpreta, 'star': star })
            }


            var membriElm = document.getElementById('troupe').children
            var membri = []

            for (let elem of membriElm) {
                var pers = elem.getAttribute('id')
                var ruolo = elem.children[3].children[0].value
                var star = elem.children[4].children[1].children[0].checked
                membri.push({ 'personaggio': pers, 'ruolo': ruolo, 'star': star })
            }

            var selectedOptions = document.getElementById('selectedOptions').children;
            var categorie = Array.from(selectedOptions).map(option => option.getAttribute('id'));

            var stagioniElm = document.getElementById('stagioni') ? document.getElementById('stagioni').children : []
            var stagioni = []

            for (let elem of stagioniElm) {
                var numero = elem.children[3].children[0].children[1].value
                var data = elem.children[3].children[1].children[1].value
                var episodi = elem.children[3].children[2].children[1].value
                var copertina = elem.children[2].children[0].children[0].src;
                if (copertina == " ../../media/addImage.jpg") copertina == "../../media/noCopertina.jpg"
                stagioni.push({ 'numero_stagione': numero, 'episodi': episodi, 'data_pubblicazione': data, 'copertina': copertina })
            }

            if (isFilm && titoloProgramma && descrizioneProgramma && copertinaProgramma && trailerProgramma && durataFilm && dataFilm && produttori.length > 0 && attori.length > 0 && membri && categorie.length > 0) {
                formData.append('titolo', titoloProgramma)
                formData.append('descrizione', descrizioneProgramma)
                formData.append('copertina', copertinaProgramma)
                formData.append('trailer', trailerProgramma)
                formData.append('durata', durataFilm)
                formData.append('data_pubblicazione', dataFilm)
                formData.append('produttori', JSON.stringify(produttori));
                formData.append('attori', JSON.stringify(attori));
                formData.append('membri', JSON.stringify(membri));
                formData.append('categorie', JSON.stringify(categorie));
                if (id) formData.append('id', id)

                fetch('../services/creaFilm.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => { return response.json() })
                    .then(response => {
                        if (response.success) {
                            showToast(id ? "Film modificato con successo" : "Film creato con successo", false)
                            setTimeout(function () {
                                url = window.location.href
                                var currentURL = new URL(url);
                                currentURL.pathname = '/MovieMania/code/admin/src/pages/film/film.php';
                                window.location.href = currentURL.href;
                            }, 1500)
                        }
                        else {
                            throw new Error(response.message);
                        }
                    })
                    .catch(error => {
                        showToast("Errore: " + error.message);
                    })
            }

            else if (isSerie && titoloProgramma && descrizioneProgramma && copertinaProgramma && trailerProgramma && serieFinita != null && produttori.length > 0 && attori.length > 0 && membri && categorie.length > 0 && stagioni.length > 0) {
                formData.append('titolo', titoloProgramma)
                formData.append('descrizione', descrizioneProgramma)
                formData.append('copertina', copertinaProgramma)
                formData.append('trailer', trailerProgramma)
                formData.append('serieFinita', serieFinita)
                formData.append('produttori', JSON.stringify(produttori));
                formData.append('attori', JSON.stringify(attori));
                formData.append('membri', JSON.stringify(membri));
                formData.append('categorie', JSON.stringify(categorie));
                formData.append('stagioni', JSON.stringify(stagioni));
                if (id) formData.append('id', id)

                fetch('../services/creaSerie.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => { return response.json() })
                    .then(response => {
                        if (response.success) {
                            showToast(id ? "Serie modificata con successo" : "Serie creata con successo", false)
                            setTimeout(function () {
                                url = window.location.href
                                var currentURL = new URL(url);
                                currentURL.search = ""
                                currentURL.pathname = '/MovieMania/code/admin/src/pages/serie/serie.php';
                                window.location.href = currentURL.href;
                            }, 1500)
                        }
                        else {
                            throw new Error(response.message);
                        }
                    })
                    .catch(error => {
                        showToast("Errore: " + error.message);
                    })
            }
            else {
                showToast('Inserisci tutti i dati correttamente e riprova!')
            }
        })
    }

    form.addEventListener('reset', event => {
        event.preventDefault();
        url = window.location.href
        var currentURL = new URL(url);
        currentURL.search = ""
        if (isFilm) currentURL.pathname = '/MovieMania/code/admin/src/pages/film/film.php';
        if (isSerie) currentURL.pathname = '/MovieMania/code/admin/src/pages/serie/serie.php';
        window.location.href = currentURL.href;
    })

})

$(window).off('beforeunload');

window.addEventListener('beforeunload', function (event) {
    event.preventDefault();
    fetch('../services/rimuovi_file.php')
});
