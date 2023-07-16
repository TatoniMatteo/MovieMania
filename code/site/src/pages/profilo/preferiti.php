<?php
require_once '../../../../include/config.php';
require_once '../../php/utility.php';
session_start();

$config = Config::getInstance();
$personaggiController = $config->getPersonaggiController();
$utentiController = $config->getUtentiController();

if (isset($_SESSION['utente'])) {
    $utente = $utentiController->getUtenteById($_SESSION['utente']);
    $permessi = array_map('intval', explode(",", $utente['permessi']));
    if ($utente != null) {
        $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 0;
        $limit = 5;
        $offset = $pagina * $limit;
        $programmiPreferiti = $utentiController->getPreferiti($utente['id'], $offset, $limit);
        $totale = $utentiController->countPreferiti($utente['id']);
        $pagine = ceil($totale / $limit);

        include 'userfavoritelist.html';
    } else {
        header("Location: ../../../../site/src");
        exit;
    }
} else {
    header("Location: ../../../../site/src");
    exit;
}
