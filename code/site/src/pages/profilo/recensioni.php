<?php
require_once '../../../../include/config.php';
session_start();

$config = Config::getInstance();
$recensioniController = $config->getRecensioniController();
$utentiController = $config->getUtentiController();

if (isset($_SESSION['utente'])) {
    $utente = $utentiController->getUtenteById($_SESSION['utente']);
    $permessi = array_map('intval', explode(",", $utente['permessi']));
    if ($utente != null) {


        $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 0;
        $limit = 5;
        $offset = $pagina * $limit;
        $recensioni = $recensioniController->getRecesioniByUtente($utente['id'], $offset, $limit);
        $totale = $recensioniController->countRecesioniByUtente($utente['id']);
        $pagine = ceil($totale / $limit);

        include 'userrate.html';
    } else {
        header("Location: ../../../../site/src");
        exit;;
    }
} else {
    header("Location: ../../../../site/src");
    exit;
}
