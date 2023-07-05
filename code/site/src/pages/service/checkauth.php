<?php
session_start();

$response = array();

if (isset($_SESSION['utente'])) {
    $response['loggedIn'] = true;
} else {
    $response['loggedIn'] = false;
}

header('Content-Type: application/json');
echo json_encode($response);
