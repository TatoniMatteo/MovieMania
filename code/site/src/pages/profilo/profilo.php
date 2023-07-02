<?php
require_once '../../../../include/config.php';
session_start();

$config = Config::getInstance();
$utentiController = $config->getUtentiController();

if (isset($_SESSION['utente'])) {
    $utente = $utentiController->getUtenteById($_SESSION['utente']);
    if ($utente != null) {
        include 'userprofile.html';
    } else {
        include '../service/404.html';
    }
} else {
    include '../service/404.html';
}
