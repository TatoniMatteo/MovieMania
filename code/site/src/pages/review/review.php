<?php

require_once '../../../../include/config.php';
require_once '../../php/utility.php';
session_start();

$config = Config::getInstance();
$recensioniController = $config->getRecensioniController();
$filmcontroller = $config->getFilmController();
$seriecontroller = $config->getSerieController();
$utentiController = $config->getUtentiController();

if (!isset($_GET['id']) or !isset($_GET['tipo']) or !isset($_SESSION['utente'])) {
    include '../service/404.html';
} else {
    $rate = 1;
    if (isset($_GET['rate'])) {
        $rate = intval($_GET['rate']);
    }
    $utente = $utentiController->getUtenteById($_SESSION['utente']);
    $permessi = $array = array_map('intval', explode(",", $utente['permessi']));
    $programmaId = $_GET['id'];
    $tipo = $_GET['tipo'];
    $programma = null;
    if ($tipo == 'film') {
        $programma = $filmcontroller->getFilmById($programmaId);
    } else if ($tipo == 'serie') {
        $programma = $seriecontroller->getSerieById($programmaId);
    } else {
        include '../service/404.html';
    }
    if ($programma == null) {
        include '../service/404.html';
    } else {
        $recensione = $recensioniController->getRecensione($utente['id'], $programmaId, $tipo);
        if ($recensione) $rate = intval($recensione['voto']);
        include 'review.html';
    }
}
