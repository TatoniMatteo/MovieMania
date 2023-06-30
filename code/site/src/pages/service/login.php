<?php

require_once '../../../../include/config.php';
$config = Config::getInstance();

$authController = $config->getAuthController();

if (!isset($_POST['username']) or !isset($_POST['password'])) {
    $response = array('success' => false, 'message' => 'Dati mancanti. Compilare tutti i campi!');
} else {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($authController->loginControl($username, $password)) {
        $response = array('success' => true);
    } else {
        $response = array('success' => false, 'message' => 'Credenziali non valide!');
    }
}

header('Content-Type: application/json');
echo json_encode($response);
