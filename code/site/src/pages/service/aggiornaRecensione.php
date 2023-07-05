<?php

require_once '../../../../include/config.php';
session_start();
$config = Config::getInstance();

$recensioniController = $config->getRecensioniController();

if (!isset($_POST['voto']) or !isset($_POST['titolo']) or !isset($_POST['descrizione']) or !isset($_POST['id_programma']) or !isset($_POST['tipo']) or !isset($_SESSION['utente'])) {
    $response = array('success' => false, 'message' => 'Dati inseriti non validi!');
} else {
    $id_utente = $_SESSION['utente'];
    $voto = $_POST['voto'];
    $titolo = $_POST['titolo'];
    $descrizione = $_POST['descrizione'];
    $tipo = $_POST['tipo'];
    $id_programma = $_POST['id_programma'];

    if ($recensioniController->getRecensione($id_utente, $id_programma, $tipo)) {
        if ($recensioniController->editRecensione($id_utente, $id_programma, $tipo, $titolo, $descrizione, $voto)) {
            $response = array('success' => true);
        } else {
            $response = array('success' => false, 'message' => 'Connessione con il database non riuscita');
        }
    } else {
        if ($recensioniController->addRecensione($id_utente, $id_programma, $tipo, $titolo, $descrizione, $voto)) {
            $response = array('success' => true);
        } else {
            $response = array('success' => false, 'message' => 'Connessione con il database non riuscita');
        }
    }
}

header('Content-Type: application/json');
echo json_encode($response);
