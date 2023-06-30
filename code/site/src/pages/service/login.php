<?php

require_once '../../../../include/config.php';
$config = Config::getInstance();

$authController = $config->getAuthController();

if (!isset($_POST['username']) or !isset($_POST['password'])) {
    // Dati mancanti, restituisci un messaggio di errore
    $response = array('success' => false, 'message' => 'Dati mancanti. Compilare tutti i campi!');
} else {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($authController->loginControl($username, $password)) {
        // Login riuscito, restituisci una risposta di successo
        $response = array('success' => true);
    } else {
        // Login fallito, restituisci un messaggio di errore
        $response = array('success' => false, 'message' => 'Credenziali non valide!');
    }
}

// Imposta l'intestazione della risposta come JSON
header('Content-Type: application/json');

// Restituisci la risposta come JSON
echo json_encode($response);
