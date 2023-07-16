<?php
require_once '../../../../include/config.php';
session_start();

$config = Config::getInstance();

$filmController = $config->getFilmController();
$serieController = $config->getSerieController();
$personaggiController = $config->getPersonaggiController();
$utentiController = $config->getUtentiController();

if (isset($_SESSION['utente'])) {
    $utente = $utentiController->getUtenteById($_SESSION['utente']);
    $permessi = array_map('intval', explode(",", $utente['permessi']));
} else {
    $utente = null;
}

$film = $filmController->getMainFilms(8);
$serie = $serieController->getMainSeries(8);

$programmi = array_merge($film, $serie);
shuffle($programmi);

$ultimiFilm = $filmController->getLastFilms();
$miglioriFilm = $filmController->getBestFilms();
$votatiFilm = $filmController->getBestReviewedFilms();

$ultimeSerie = $serieController->getLastSeries();
$miglioriSerie = $serieController->getBestSeries();
$votateSerie = $serieController->getBestReviewedSeries();

$starEvidenza = $personaggiController->getStarinEvidenza();

include 'home.html';
