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
    $limit = 15;
    $offset = $pagina * $limit;
    $ordinamento = isset($_GET['ord']) ? $_GET['ord'] : 0;
    $ruoli = array();
    if (isset($_GET['ruoli'])) {
        $stringa = $_GET['ruoli'];
        if (str_contains($stringa, ',')) {
            $ruoli = explode(",", $stringa);
        } else {
            $ruoli[] = $stringa;
        }
        foreach ($ruoli as &$numero) {
            $numero = intval(trim($numero));
        }
    }
    $celebrita = $searchController->search($testo, $filtro, $offset, $limit, $ordinamento, $ruoli);
    $totale = $searchController->countCelebritaResults($testo, $ruoli);
    $pagine = ceil($totale / $limit);
} else {
    $testo = null;
    $filtro = null;
    $celebrita = array();
}

$ruoli = $searchController->getAllRuoli();

include 'celebritygrid.html';

/*
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
    $categorie = array();
    if (isset($_GET['categorie'])) {
        $stringa = $_GET['categorie'];
        if (str_contains($stringa, ',')) {
            $categorie = explode(",", $stringa);
        } else {
            $categorie[] = $stringa;
        }
        foreach ($categorie as &$numero) {
            $numero = intval(trim($numero));
        }
    }

    $programmi = $searchController->search($testo, $filtro, $offset, $limit, $ordinamento, $categorie);
    $totale = count($programmi);
    $pagine = ceil($totale / $limit);
} else {
    $testo = null;
    $filtro = null;
    $programmi = array();
}

$categorie = $searchController->getAllCategorie();

include 'moviegrid.html';
*/
