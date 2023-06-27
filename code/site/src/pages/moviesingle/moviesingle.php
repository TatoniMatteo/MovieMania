<?php

require_once '../../../../include/config.php';

$config = Config::getInstance();

$filmController = $config->getFilmController();


if (!isset($_GET['id'])) {
    include '../error/404.html';
} else {
    $filmId = $_GET['id'];
    $film = $filmController->getFilmById($filmId);
    if ($film == null) {
        include '../error/404.html';
    } else {
        include 'moviesingle.html';
    }
}
