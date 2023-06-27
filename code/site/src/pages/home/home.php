<?php
require_once '../../../../include/config.php';
$config = Config::getInstance();

$filmController = $config->getFilmController();
$serieController = $config->getSerieController();

$film = $filmController->getAllFilms();
$serie = $serieController->getAllSeries();

$programmi = array_merge($film, $serie);
shuffle($programmi);

$ultimiFilm = $filmController->getLastFilms();
$miglioriFilm = $filmController->getBestFilms();
$votatiFilm = $filmController->getBestReviewedFilms();

$ultimeSerie = $serieController->getLastSeries();
$miglioriSerie = $serieController->getBestSeries();
$votateSerie = $serieController->getBestReviewedSeries();

include 'home.html';
