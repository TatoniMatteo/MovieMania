<?php
require_once '../../../../include/config.php';
session_start();

$config = Config::getInstance();
$recensioniController = $config->getRecensioniController();
$utentiController = $config->getUtentiController();

if (isset($_SESSION['utente'])) {
    $utente = $utentiController->getUtenteById($_SESSION['utente']);
    $permessi = $array = array_map('intval', explode(",", $utente['permessi']));
    if ($utente != null) {
        $recensioni = $recensioniController->getRecesioniByUtente($utente['id']);
        $numero_recensioni = count($recensioni);
        include 'userrate.html';
    } else {
        include '../service/404.html';
    }
} else {
    include '../service/404.html';
}
