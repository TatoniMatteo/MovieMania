<?php
require_once '../../../../include/config.php';
session_start();

$config = Config::getInstance();
$personaggiController = $config->getPersonaggiController();
$utentiController = $config->getUtentiController();
$searchController = $config->getSearchController();

if (isset($_SESSION['utente'])) {
    $utente = $utentiController->getUtenteById($_SESSION['utente']);
    $permessi = array_map('intval', explode(",", $utente['permessi']));
} else {
    $utente = null;
}

if (isset($_GET['testo'])) {
    $testo = $_GET['testo'];
    $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 0;
    $limit = 15;
    $offset = $pagina * $limit;
    $ordinamento = isset($_GET['ord']) ? $_GET['ord'] : 0;
    $ruoli = "";
    if (isset($_GET['ruoli'])) {
        $ruoli = $_GET['ruoli'];
    }
    $celebrita = $searchController->search($testo, "celebrita", $offset, $limit, $ordinamento, $ruoli);
    $totale = $searchController->countCelebritaResults($testo, $ruoli);
    $pagine = ceil($totale / $limit);
} else {
    $testo = null;
    $celebrita = array();
}

$ruoli = $searchController->getAllRuoli();

include 'celebritygrid.html';
