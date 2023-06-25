<?php
require_once '../../../../include/config.php';
$config = Config::getInstance();

$filmController = $config->getFilmController();
$serieController = $config->getSerieController();

$film = $filmController->getAllFilms();
$serie = $serieController->getAllSeries();

$programmi = array_merge($film, $serie);
shuffle($programmi);

include 'home.html';
