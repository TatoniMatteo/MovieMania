<?php
require_once '../../../../include/config.php';
session_start();

$config = Config::getInstance();
$personaggiController = $config->getPersonaggiController();
$utentiController = $config->getUtentiController();
$searchController = $config->getSearchController();

if (isset($_SESSION['utente'])) {
    $utente = $utentiController->getUtenteById($_SESSION['utente']);
} else {
    $utente = null;
}

if (isset($_GET['testo']) && isset($_GET['filtro'])) {
    $testo = $_GET['testo'];
    $filtro = $_GET['filtro'];
} else {
    $testo = null;
    $filtro = null;
}

include 'celebritygrid.html';
