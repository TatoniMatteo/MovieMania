<?php
require_once '../../../../include/config.php';
require_once '../../../../site/src/php/utility.php';
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

$filtro = (isset($_GET['filtro'])) ? $_GET['filtro'] : "";
$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 0;
$limit = 15;
$offset = $pagina * $limit;
$personaggi = $statsController->getAllPersonaggi($offset, $limit, $filtro);
$totale = $statsController->getNumeroPersonaggi($filtro);
$pagine = ceil($totale / $limit);

include 'celebrita.html';
