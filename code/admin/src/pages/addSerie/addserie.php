<?php
require_once '../../../../include/config.php';
require_once '../../../../site/src/php/utility.php';
session_start();

$config = Config::getInstance();
$utentiController = $config->getUtentiController();
$statsController = $config->getStatisticheController();

if (isset($_SESSION['utente'])) {
    $utente = $utentiController->getUtenteById($_SESSION['utente']);
} else {
    $utente = null;
}

$serieId = null;
if (isset($_GET['id'])) {
    $serieId = $_GET['id'];
}

$categorie = $statsController->getAllCategorie();

include 'addserie.html';
