document.addEventListener("DOMContentLoaded", async (event) => {
    var searchForm = document.getElementById("search")
    searchForm.addEventListener("submit", async (event) => {
        event.preventDefault();
        var filtro = document.getElementById("filter").value

        var url = window.location.href;
        var currentURL = new URL(url)
        var urlParams = new URLSearchParams()
        urlParams.append('filtro', filtro);
        currentURL.search = urlParams.toString();
        window.location.href = currentURL.href;
    })

})