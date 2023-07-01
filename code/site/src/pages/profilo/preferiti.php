<?php
require_once '../../../../include/config.php';
session_start();

$config = Config::getInstance();
$utentiController = $config->getUtentiController();

if (isset($_SESSION['utente'])) {
    $utente = $utentiController->getUtenteById($_SESSION['utente']);
    include 'userfavoritelist.html';
} else {
    include '../service/404.html';
}
