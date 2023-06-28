<?php

require_once '../../../../include/config.php';

$config = Config::getInstance();

$personaggiController = $config->getPersonaggiController();

if (!isset($_GET['id'])) {
    include '../service/404.html';
} else {
    $personaggioId = $_GET['id'];
    $personaggio = $personaggiController->getPersonaggioById($personaggioId);
    if ($personaggio == null) {
        include '../service/404.html';
    } else {
        include 'celebritysingle.html';
    }
}

function troncaStringa($stringa, $limite)
{
    if (strlen($stringa) <= $limite) {
        return $stringa; // La stringa è già più corta o uguale al limite
    }

    // Trova l'ultima occorrenza di uno spazio prima del limite
    $ultimaOccorrenzaSpazio = strrpos(substr($stringa, 0, $limite), ' ');

    // Tronca la stringa fino all'ultima occorrenza di spazio
    $stringaTroncata = substr($stringa, 0, $ultimaOccorrenzaSpazio);

    // Aggiungi i tre puntini
    $stringaTroncata .= ' ...';

    return $stringaTroncata;
}
