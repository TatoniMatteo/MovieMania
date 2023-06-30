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
} else {
    $utente = null;
}

$film = $filmController->getAllFilms(8);
$serie = $serieController->getAllSeries(8);

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
