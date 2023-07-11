<?php
require_once '../../../../include/config.php';
session_start();

$config = Config::getInstance();
$utentiController = $config->getUtentiController();

if (isset($_SESSION['utente'])) {
    $utente = $utentiController->getUtenteById($_SESSION['utente']);
    $permessi = $array = array_map('intval', explode(",", $utente['permessi']));
    if ($utente != null) {
        include 'userprofile.html';
    } else {
        include '../service/404.html';
    }
} else {
    include '../service/404.html';
}
