document.addEventListener('DOMContentLoaded', async () => {

    var amministratori = document.getElementsByClassName('amministratore')
    var creatori = document.getElementsByClassName('creatore')

    for (let ammin of amministratori) {
        ammin.addEventListener('change', () => {

            var id = ammin.id
            var create = null
            for (var i = 0; i < creatori.length; i++) {
                if (creatori[i].id == id) {
                    create = creatori[i];
                }
            }

            if (!ammin || !create) {
                alert("OPS! Qualcosa è andato storto!")
                window.location.reload();
            } else {

                var permessi = []
                if (ammin.checked) {
                    permessi.push(2)
                    permessi.push(3)
                    create.checked = true
                }
                else {
                    if (create.checked) permessi.push(3)
                }

                var formData = new FormData()
                formData.append('id', id)
                formData.append('permessi', permessi)

                fetch('../services/modificaPermessi.php', {
                    method: 'POST',
                    body: formData
                })
                    .then((response) => { return response.json(); })
                    .then((data) => {
                        if (data.success) {
                            alert('Permessi modificati con successo!')
                        } else {
                            throw new Error(data.message);
                        }
                    })
                    .catch((error) => {
                        alert('Errore: ', error.message);
                    })
            }
        })
    }

    for (let create of creatori) {
        create.addEventListener('change', () => {

            var id = create.id
            var ammin = null
            for (var i = 0; i < amministratori.length; i++) {
                if (amministratori[i].id == id) {
                    ammin = amministratori[i];
                }
            }

            if (!ammin || !create) {
                alert("OPS! Qualcosa è andato storto!")
                window.location.reload();
            } else {

                var permessi = []
                if (create.checked) {
                    if (ammin.checked) permessi.push(2)
                    permessi.push(3)
                }
                else {
                    ammin.checked = false
                }

                var formData = new FormData()
                formData.append('id', id)
                formData.append('permessi', permessi)

                fetch('../services/modificaPermessi.php', {
                    method: 'POST',
                    body: formData
                })
                    .then((response) => { return response.json(); })
                    .then((data) => {
                        if (data.success) {
                            alert('Permessi modificati con successo!')
                        } else {
                            throw new Error(data.message);
                        }
                    })
                    .catch((error) => {
                        alert('Errore: ', error.message);
                    })
            }
        })
    }
})