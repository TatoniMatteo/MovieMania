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
} else {
    $utente = null;
}

if (!isset($_GET['id'])) {
    include '../service/404.html';
} else {
    $personaggioId = $_GET['id'];
    $personaggio = $personaggiController->getPersonaggioById($personaggioId);
    if ($personaggio == null) {
        include '../service/404.html';
    } else {
        $filmografia = $personaggiController->getFilmographyById($personaggioId);
        $ruoli = $personaggiController->getRuoliInterpretati($personaggioId);
        include 'celebritysingle.html';
    }
}
