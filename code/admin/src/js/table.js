var pagination = document.querySelector('.pagination2');
if (pagination) {
    var pages = pagination.querySelectorAll('.page, .page-last');
    for (var i = 0; i < pages.length; i++) {
        pages[i].addEventListener('click', function () {
            var linkValue = parseInt(this.textContent.trim());
            var urlParams = new URLSearchParams(window.location.search);
            var currentPage = parseInt(urlParams.get('pagina'));
            var newPage = linkValue - 1;

            if (isNaN(currentPage)) {
                urlParams.append('pagina', newPage);
            } else {
                urlParams.set('pagina', newPage);
            }

            window.location.search = urlParams.toString();
        });
    }
}
