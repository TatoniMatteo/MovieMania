<?php

require_once '../../../../include/config.php';
session_start();

$config = Config::getInstance();
$personaggiController = $config->getPersonaggiController();
$utentiController = $config->getUtentiController();

if (isset($_SESSION['utente'])) {
    $utente = $utentiController->getUtenteById($_SESSION['utente']);
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

function troncaStringa($stringa, $limite)
{
    if (strlen($stringa) <= $limite) {
        return $stringa;
    }

    $ultimaOccorrenzaSpazio = strrpos(substr($stringa, 0, $limite), ' ');
    $stringaTroncata = substr($stringa, 0, $ultimaOccorrenzaSpazio);
    $stringaTroncata .= ' ...';

    return $stringaTroncata;
}
