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
    $preferito = $utentiController->isPreferito($utente['id'], $filmId, 'film');
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
        $categorie = $filmController->getCategoriesOfFilm($filmId);
        $personaggi = $personaggiController->getPersonaggiByFilm($filmId);
        $numero_recensioni = $recensioniController->getNumeroRecesioniByFilm($filmId);
        $film_correlati = $filmController->getFilmCorrelati($filmId);
        include 'moviesingle.html';
    }
}
