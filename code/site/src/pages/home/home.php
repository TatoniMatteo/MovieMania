<?php
require_once '../../../../include/config.php';
$config = Config::getInstance();

$filmController = $config->getFilmController();
$serieController = $config->getSerieController();
$personaggiController = $config->getPersonaggiController();

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
