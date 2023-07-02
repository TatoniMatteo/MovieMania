<?php

require_once '../../../../include/config.php';
$config = Config::getInstance();

$authController = $config->getAuthController();

if (!isset($_POST['nome']) || !isset($_POST['cognome']) || !isset($_POST['username']) || !isset($_POST['email']) || !isset($_POST['password'])) {
    $response = array('success' => false, 'message' => 'Dati mancanti');
} else {
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Esegui la logica di registrazione
    $result = $authController->registerUser($nome, $cognome, $username, $email, $password);

    if ($result === true) {
        $response = array('success' => true);
    } else {
        $response = array('success' => false, 'message' => 'Errore durante la registrazione: username e/o email già in uso!');
    }
}

header('Content-Type: application/json');
echo json_encode($response);
