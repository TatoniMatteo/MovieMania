<?php

require_once '../../../../include/config.php';
session_start();
$config = Config::getInstance();

$utentiController = $config->getUtentiController();

if (!isset($_POST['username']) or !isset($_POST['email']) or !isset($_POST['nome']) or !isset($_POST['cognome']) or !isset($_SESSION['utente'])) {
    $response = array('success' => false, 'message' => 'Dati inseriti non validi!');
} else {
    $id_utente = $_SESSION['utente'];
    $username = $_POST['username'] != "" ? $_POST['username'] : null;
    $email = $_POST['email'] != "" ? $_POST['email'] : null;
    $nome = $_POST['nome'] != "" ? $_POST['nome'] : null;
    $cognome = $_POST['cognome'] != "" ? $_POST['cognome'] : null;

    if ($username or $email or $nome or $cognome) {
        if ($utentiController->updateDati($id_utente, $username, $email, $nome, $cognome)) {
            $response = array('success' => true);
        } else {
            $response = array('success' => false, 'message' => 'Problemi di connessione con il server');
        }
    } else {
        $response = array('success' => false, 'message' => 'Dati inseriti non validi!');
    }
}

header('Content-Type: application/json');
echo json_encode($response);
