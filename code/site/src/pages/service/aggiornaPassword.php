<?php

require_once '../../../../include/config.php';
session_start();
$config = Config::getInstance();

$utentiController = $config->getUtentiController();

if (!isset($_POST['old']) or !isset($_POST['new']) or !isset($_POST['retype']) or !isset($_SESSION['utente'])) {
    $response = array('success' => false, 'message' => 'Dati inseriti non validi!');
} else {
    $id_utente = $_SESSION['utente'];
    $old = $_POST['old'] != "" ? $_POST['old'] : null;
    $new = $_POST['new'] != "" ? $_POST['new'] : null;
    $retype = $_POST['retype'];

    if ($old && $new) {
        if ($new == $retype) {
            if ($utentiController->updatePassword($id_utente, $old, $new)) {
                $response = array('success' => true);
            } else {
                $response = array('success' => false, 'message' => 'La vecchia password è sbagliata!');
            }
        } else {
            $response = array('success' => false, 'message' => 'Le due password non coincidono!');
        }
    } else {
        $response = array('success' => false, 'message' => 'Dati inseriti non validi!');
    }
}

header('Content-Type: application/json');
echo json_encode($response);
