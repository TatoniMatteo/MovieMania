<?php

require_once '../../../../include/config.php';
require_once '../../php/utility.php';
session_start();

$config = Config::getInstance();

$filmController = $config->getFilmController();
$personaggiController = $config->getPersonaggiController();
$recensioniController = $config->getRecensioniController();
$utentiController = $config->getUtentiController();

if (isset($_SESSION['utente'])) {
    $utente = $utentiController->getUtenteById($_SESSION['utente']);
    $permessi = array_map('intval', explode(",", $utente['permessi']));
} else {
    $utente = null;
}


if (!isset($_GET['id'])) {
    include '../service/404.html';
} else {
    $filmId = $_GET['id'];
    $film = $filmController->getFilmById($filmId);
    if ($film == null) {
        include '../service/404.html';
    } else {
        $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 0;
        $limit = 15;
        $offset = $pagina * $limit;
        $ordinamento = isset($_GET['ord']) ? $_GET['ord'] : 0;

        $categorie = $filmController->getCategoriesOfFilm($filmId);
        $personaggi = $personaggiController->getPersonaggiByFilm($filmId);
        $stars = getstars($personaggi);
        $thereAreMembri = thereAreMembri($personaggi);
        $thereAreScrittori = thereAreScrittori($personaggi);
        $thereAreRegisti = thereAreRegisti($personaggi);
        $numero_recensioni = $recensioniController->getNumeroRecesioniByFilm($filmId);
        $pagine = ceil($numero_recensioni / $limit);
        $film_correlati = $filmController->getFilmCorrelati($filmId);
        $recensioni = $recensioniController->getRecensioniByFilm($filmId, $offset, $limit, $ordinamento);
        $recensione = null;
        if ($utente != null) {
            $preferito = $utentiController->isPreferito($utente['id'], $filmId, 'film');
            $recensione = $recensioniController->getRecensione($utente['id'], $filmId, 'film');
        }

        include 'moviesingle.html';
    }
}
