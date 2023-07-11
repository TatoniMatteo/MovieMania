<?php
require_once '../../../../include/config.php';
require_once '../../php/utility.php';
session_start();

$config = Config::getInstance();
$personaggiController = $config->getPersonaggiController();
$utentiController = $config->getUtentiController();

if (isset($_SESSION['utente'])) {
    $utente = $utentiController->getUtenteById($_SESSION['utente']);
    $permessi = $array = array_map('intval', explode(",", $utente['permessi']));
    if ($utente != null) {
        $programmiPreferiti = $utentiController->getPreferiti($utente['id']);
        $numero_preferiti = count($programmiPreferiti);
        include 'userfavoritelist.html';
    } else {
        include '../service/404.html';
    }
} else {
    include '../service/404.html';
}
