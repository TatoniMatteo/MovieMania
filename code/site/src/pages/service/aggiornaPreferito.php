<?php

require_once '../../../../include/config.php';
session_start();
$config = Config::getInstance();

$utentiController = $config->getUtentiController();

if (!isset($_POST['id_programma']) or !isset($_POST['tipo']) or !isset($_SESSION['utente'])) {
    $response = array('success' => false, 'message' => 'Operazione non valida. (Dati mancanti)');
} else {
    $id_utente = $_SESSION['utente'];
    $id_programma = $_POST['id_programma'];
    $tipo = $_POST['tipo'];

    $isPreferito = $utentiController->isPreferito($id_utente, $id_programma, $tipo);

    if ($isPreferito) {
        if ($utentiController->removePreferito($id_utente, $id_programma, $tipo)) {
            $res = array('success' => true, 'message' => 'preferito rimosso', 'preferito' => false);
        } else {
            $res = array('success' => false, 'message' => 'erroe col db', 'preferito' => true);
        }
    } else {
        if ($utentiController->addPreferito($id_utente, $id_programma, $tipo)) {
            $res = array('success' => true, 'message' => 'preferito aggiunto', 'preferito' => true);
        } else {
            $res = array('success' => false, 'message' => 'erroe col db', 'preferito' => false);
        }
    }
}

header('Content-Type: application/json');
echo json_encode($res);
