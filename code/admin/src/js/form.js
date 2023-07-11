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
        throw error;
    }
}

function filter(filtro, personaggio) {
    filtro = filtro.toUpperCase()
    personaggio = personaggio.toUpperCase()
    return personaggio.includes(filtro)
}

function createDiv(row, align, elements, margin = 10) {
    var div = document.createElement('div')
    if (row) div.classList.add('row')
    else {
        div.classList.add('col')
        div.classList.add(`col-md-3`)
        div.style.marginBottom = margin + 'px'
    }
    if (align) div.classList.add(align)
    div.classList.add("align-middle")
    elements.forEach(element => div.appendChild(element))

    return div
}

function createSelect(data, defaultValue) {
    var select = document.createElement('select')
    select.classList.add('form-control')

    data.forEach(data => {
        var option = document.createElement('option')
        option.textContent = data.ruolo
        option.value = data.id
        select.appendChild(option)
    })
    select.value = defaultValue

    return select
}

function createCheckbox(defaultValue = false) {
    var labelStar = document.createElement("label")
    labelStar.classList.add("form-check-label")
    labelStar.setAttribute("for", "checkbox")
    labelStar.textContent = "STAR"
    labelStar.style.marginRight = "10px"

    var checkbox = document.createElement("input")
    checkbox.setAttribute("type", "checkbox")
    checkbox.setAttribute("id", "checkbox")
    if (defaultValue)
        checkbox.setAttribute("checked", "checked")

    return createDiv(false, "text-center", [labelStar, checkbox], 0)

}


function addProduttore(nome, id, star, ruolo) {
    var produttori = document.getElementById('produttori')

    var space = createDiv(false, "text-left", []);

    var labelNome = document.createElement("label")
    labelNome.innerHTML = nome
    labelNome.classList.add("form-control-label")
    var divNome = createDiv(false, "text-left", [labelNome]);

    var roleSelect = createSelect([{ ruolo: "Produttore", id: 1 }, { ruolo: "Scrittore", id: 4 }], ruolo)
    var divRole = createDiv(false, "text-center", [roleSelect])

    var divStar = createCheckbox(star)

    var produttore = createDiv(true, null, [space, divNome, divRole, divStar]);
    produttore.setAttribute("id", id)

    produttori.appendChild(produttore)
}

function addAttore(nome, id, star, ruolo) {
    var attori = document.getElementById('attori');

    var space = createDiv(false, "text-left", []);

    var labelNome = document.createElement("label")
    labelNome.innerHTML = nome
    labelNome.classList.add("form-control-label")
    var divNome = createDiv(false, "text-left", [labelNome]);

    var divStar = createCheckbox(star)

    var divInterpreta = document.createElement("div");
    divInterpreta.classList.add("col");
    divInterpreta.classList.add("col-md-3");

    var interpretaInput = document.createElement("input");
    interpretaInput.classList.add("form-control");
    interpretaInput.setAttribute("type", "text");
    interpretaInput.setAttribute("placeholder", "interpreta");

    divInterpreta.appendChild(interpretaInput);

    var attore = createDiv(true, null, [space, divNome, divInterpreta, divStar]);
    attore.setAttribute("id", id)
    attori.appendChild(attore);

    interpretaInput.value = ruolo;
}


function addMembro(nome, id, star, ruolo) {
    var membri = document.getElementById('troupe')

    var space = createDiv(false, "text-left", []);

    var labelNome = document.createElement("label")
    labelNome.innerHTML = nome
    labelNome.classList.add("form-control-label")
    var divNome = createDiv(false, "text-left", [labelNome]);

    var roleSelect = createSelect([{ ruolo: "Produttore", id: 1 }, { ruolo: "Scrittore", id: 4 }], ruolo)
    var divRole = createDiv(false, "text-center", [roleSelect])

    var divStar = createCheckbox(star)

    var membro = createDiv(true, null, [space, divNome, divRole, divStar]);
    membro.setAttribute("id", id)

    membri.appendChild(membro)
}

document.addEventListener('DOMContentLoaded', async () => {

    var personaggi1 = document.getElementById('personaggi1')
    var personaggi2 = document.getElementById('personaggi2')
    var personaggi3 = document.getElementById('personaggi3')

    data = await getPersonaggi()


    if (personaggi1) {
        var menu1 = document.getElementById('dropdown-menu1')
        var options1
        personaggi1.addEventListener('keyup', function (event) {
            var filtro1 = personaggi1.value
            if (!menu1.firstElementChild) {
                data.forEach(element => {
                    var option = document.createElement('option')
                    option.innerHTML = element.nome + " " + element.cognome
                    option.classList.add('dropdown-item')
                    option.value = element.id
                    option.style.cursor = 'pointer'
                    menu1.appendChild(option)
                });

                options1 = menu1.getElementsByTagName('option')
                for (let option of options1) {
                    option.addEventListener('click', function (event) {
                        addProduttore(option.innerHTML, option.value, false, 1)
                        personaggi1.value = ""
                    })
                }
            }

            var limite = 5
            var count = 0
            for (let element of options1) {
                if (filtro1 && filter(filtro1, element.innerHTML) && count < limite) {
                    element.style.display = ''
                    count++
                }
                else {
                    element.style.display = 'none'
                }
            }
        })
    }

    if (personaggi2) {
        var menu2 = document.getElementById('dropdown-menu2')
        var options2
        personaggi2.addEventListener('keyup', function (event) {
            var filtro2 = personaggi2.value
            if (!menu2.firstElementChild) {
                data.forEach(element => {
                    var option = document.createElement('option')
                    option.innerHTML = element.nome + " " + element.cognome
                    option.classList.add('dropdown-item')
                    option.value = element.id
                    menu2.appendChild(option)
                });

                options2 = menu2.getElementsByTagName('option')
                for (let option of options2) {
                    option.addEventListener('click', function (event) {
                        addAttore(option.innerHTML, option.value, false, "")
                        personaggi2.value = ""
                    })
                }
            }

            var limite = 5
            var count = 0
            for (let element of options2) {
                if (filtro2 && filter(filtro2, element.innerHTML) && count < limite) {
                    element.style.display = ''
                    count++
                }
                else {
                    element.style.display = 'none'
                }
            }
        })
    }


    if (personaggi3) {
        var menu3 = document.getElementById('dropdown-menu3')
        var options3
        personaggi3.addEventListener('keyup', function (event) {
            var filtro3 = personaggi3.value
            if (!menu3.firstElementChild) {
                data.forEach(element => {
                    var option = document.createElement('option')
                    option.innerHTML = element.nome + " " + element.cognome
                    option.classList.add('dropdown-item')
                    option.value = element.id
                    menu3.appendChild(option)
                });

                options3 = menu3.getElementsByTagName('option')
                for (let option of options3) {
                    option.addEventListener('click', function (event) {
                        addMembro(option.innerHTML, option.value, false, 1)
                        personaggi3.value = ""
                    })
                }
            }

            var limite = 5
            var count = 0
            for (let element of options3) {
                if (filtro3 && filter(filtro3, element.innerHTML) && count < limite) {
                    element.style.display = ''
                    count++
                }
                else {
                    element.style.display = 'none'
                }
            }
        })
    }

    var trailerLink = document.getElementById('trailerLink')
    var trailer = document.getElementById('trailer')

    trailerLink.addEventListener('keyup', event => {
        trailer.innerHTML = event.setAttribute('src', trailerLink.value);
    }
})