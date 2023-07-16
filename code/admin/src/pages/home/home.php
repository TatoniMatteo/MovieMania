<?php
require_once '../../../../include/config.php';
session_start();

$config = Config::getInstance();
$utentiController = $config->getUtentiController();
$statsController = $config->getStatisticheController();

if (isset($_SESSION['utente'])) {
    $utente = $utentiController->getUtenteById($_SESSION['utente']);
    $permessi = array_map('intval', explode(",", $utente['permessi']));
    if (empty(array_intersect([2, 3], $permessi))) {
        header("Location: ../../../../site/src");
        exit;
    }
} else {
    header("Location: ../../../../site/src");
    exit;
}

$numero_film = $statsController->getNumeroFilm("");
$numero_serie = $statsController->getNumeroSerie("");
$numero_celebrita = $statsController->getNumeroCelebrità("");
$numero_recensioni = $statsController->getNumeroRecensioni();
include 'home.html';
