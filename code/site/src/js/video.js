var currentTrailer = null;
function playTrailer(index) {
    var iframe = document.getElementById('trailer_' + index);
    if (currentTrailer !== null && currentTrailer !== iframe) {
        currentTrailer.contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*');
    }

    currentTrailer = iframe;
    iframe.contentWindow.postMessage('{"event":"command","func":"playVideo","args":""}', '*');
}

var videoItems = document.querySelectorAll('.videos .item-video');
videoItems.forEach(function (iframe, index) {
    iframe.addEventListener('click', function () {
        playTrailer(index);
    });
});