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
    $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 0;
    $limit = 16;
    $offset = $pagina * $limit;
    $ordinamento = isset($_GET['ord']) ? $_GET['ord'] : 0;
    $categorie = "";
    if (isset($_GET['categorie'])) {
        $categorie = $_GET['categorie'];
    }

    $programmi = $searchController->search($testo, $filtro, $offset, $limit, $ordinamento, $categorie);
    $totale = $searchController->countSearchResults($testo, $filtro, $categorie);
    $pagine = ceil($totale / $limit);
} else {
    $testo = null;
    $filtro = null;
    $programmi = array();
}

$categorie = $searchController->getAllCategorie();

include 'moviegrid.html';
