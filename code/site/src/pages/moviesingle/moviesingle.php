<?php

require_once '../../../../include/config.php';

$config = Config::getInstance();

$filmController = $config->getFilmController();
$personaggiController = $config->getPersonaggiController();
$recensioniController = $config->getRecensioniController();


if (!isset($_GET['id'])) {
    include '../error/404.html';
} else {
    $filmId = $_GET['id'];
    $film = $filmController->getFilmById($filmId);
    if ($film == null) {
        include '../error/404.html';
    } else {
        $categorie = $filmController->getCategoriesOfFilm($film['id']);
        $personaggi = $personaggiController->getPersonaggiByFilm($filmId);
        $recensioni = $recensioniController->getRecensioniByFilm($filmId);
        include 'moviesingle.html';
    }
}
