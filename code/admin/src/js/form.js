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


function addProduttore(nome, id, star, ruolo) {
    var produttori = document.getElementById('produttori')

    var produttore = document.createElement("div")
    produttore.classList.add("row")
    produttore.setAttribute("id", id)

    var space = document.createElement("div")
    space.classList.add("col")
    space.classList.add("col-md-3")

    var divNome = document.createElement("div")
    divNome.classList.add("col")
    divNome.classList.add("col-md-3")

    var labelNome = document.createElement("label")
    labelNome.innerHTML = nome
    labelNome.classList.add("form-control-label")
    divNome.appendChild(labelNome)

    var divRole = document.createElement("div")
    divRole.classList.add("col")
    divRole.classList.add("col-md-3")

    var roleSelect = document.createElement("select")
    var role1 = document.createElement("option")
    role1.textContent = "Produttore"
    role1.value = 1
    roleSelect.appendChild(role1)

    var role2 = document.createElement("option")
    role2.textContent = "Scrittore"
    role2.value = 4
    roleSelect.appendChild(role2)
    divRole.appendChild(roleSelect)

    var divStar = document.createElement("div")
    divStar.classList.add("col")
    divStar.classList.add("col-md-3")

    var divCheckbox = document.createElement("div")
    divCheckbox.classList.add("row")

    var labelStar = document.createElement("label")
    labelStar.classList.add("form-check-label")
    labelStar.setAttribute("for", "checkbox")
    labelStar.textContent = "STAR"

    var checkbox = document.createElement("input")
    checkbox.setAttribute("type", "checkbox")
    checkbox.setAttribute("id", "checkbox")
    checkbox.classList.add("form-check-input")

    divStar.appendChild(divCheckbox)
    divCheckbox.appendChild(labelStar)
    divCheckbox.appendChild(checkbox)

    produttore.appendChild(space)
    produttore.appendChild(divNome)
    produttore.appendChild(divRole)
    produttore.appendChild(divStar)
    produttori.appendChild(produttore)

    roleSelect.value = ruolo
    checkbox.checked = star
}

function addAttore(nome, id, star, ruolo) {
    var attori = document.getElementById('attori')

    var attore = document.createElement("div")
    attore.classList.add("row")
    attore.setAttribute("id", id)

    var space = document.createElement("div")
    space.classList.add("col")
    space.classList.add("col-md-3")

    var divNome = document.createElement("div")
    divNome.classList.add("col")
    divNome.classList.add("col-md-3")

    var labelNome = document.createElement("label")
    labelNome.innerHTML = nome
    labelNome.classList.add("form-control-label")
    divNome.appendChild(labelNome)


    var divInterpreta = document.createElement("div")
    divInterpreta.classList.add("col")
    divInterpreta.classList.add("col-md-3")

    var interpretaInput = document.createElement("input")
    interpretaInput.classList.add("form-control")
    interpretaInput.setAttribute("type", "text")
    interpretaInput.setAttribute("placeholder", "interpreta")

    divInterpreta.appendChild(interpretaInput)

    var divStar = document.createElement("div")
    divStar.classList.add("col")
    divStar.classList.add("col-md-3")

    var divCheckbox = document.createElement("div")
    divCheckbox.classList.add("row")

    var labelStar = document.createElement("label")
    labelStar.classList.add("form-check-label")
    labelStar.setAttribute("for", "checkbox")
    labelStar.textContent = "STAR"

    var checkbox = document.createElement("input")
    checkbox.setAttribute("type", "checkbox")
    checkbox.setAttribute("id", "checkbox")
    checkbox.classList.add("form-check-input")

    divStar.appendChild(divCheckbox)
    divCheckbox.appendChild(labelStar)
    divCheckbox.appendChild(checkbox)

    attore.appendChild(space)
    attore.appendChild(divNome)
    attore.appendChild(divInterpreta)
    attore.appendChild(divStar)
    attori.appendChild(attore)

    interpretaInput.value = ruolo
    checkbox.checked = star
}


function addMembro(nome, id, star, ruolo) {
    var membri = document.getElementById('troupe')

    var membro = document.createElement("div")
    membro.classList.add("row")
    membro.setAttribute("id", id)

    var space = document.createElement("div")
    space.classList.add("col")
    space.classList.add("col-md-3")

    var divNome = document.createElement("div")
    divNome.classList.add("col")
    divNome.classList.add("col-md-3")

    var labelNome = document.createElement("label")
    labelNome.innerHTML = nome
    labelNome.classList.add("form-control-label")
    divNome.appendChild(labelNome)

    var divRole = document.createElement("div")
    divRole.classList.add("col")
    divRole.classList.add("col-md-3")

    var roleSelect = document.createElement("select")
    var role1 = document.createElement("option")
    role1.textContent = "Produttore"
    role1.value = 1
    roleSelect.appendChild(role1)

    var role2 = document.createElement("option")
    role2.textContent = "Scrittore"
    role2.value = 4
    roleSelect.appendChild(role2)
    divRole.appendChild(roleSelect)

    var divStar = document.createElement("div")
    divStar.classList.add("col")
    divStar.classList.add("col-md-3")

    var divCheckbox = document.createElement("div")
    divCheckbox.classList.add("row")

    var labelStar = document.createElement("label")
    labelStar.classList.add("form-check-label")
    labelStar.setAttribute("for", "checkbox")
    labelStar.textContent = "STAR"

    var checkbox = document.createElement("input")
    checkbox.setAttribute("type", "checkbox")
    checkbox.setAttribute("id", "checkbox")
    checkbox.classList.add("form-check-input")

    divStar.appendChild(divCheckbox)
    divCheckbox.appendChild(labelStar)
    divCheckbox.appendChild(checkbox)

    membro.appendChild(space)
    membro.appendChild(divNome)
    membro.appendChild(divRole)
    membro.appendChild(divStar)
    membri.appendChild(membro)

    roleSelect.value = ruolo
    checkbox.checked = star
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
                        addAttore(option.innerHTML, option.value, true, "Thor")
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
                        addMembro(option.innerHTML, option.value, true, 1)
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

})