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

$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 0;
$limit = 15;
$offset = $pagina * $limit;
$personaggi = $statsController->getAllPersonaggi($offset, $limit);
$totale = $statsController->getNumeroPersonaggi();
$pagine = ceil($totale / $limit);

include 'celebrita.html';
