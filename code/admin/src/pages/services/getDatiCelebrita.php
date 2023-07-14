<?php
require_once '../../../../include/config.php';
header('Content-Type: application/json');

$config = Config::getInstance();
$personaggiController = $config->getPersonaggiController();

if (!isset($_GET['id'])) {
    $response = array('success' => false, 'message' => 'Dati mancanti');
    echo json_encode($response);
    exit();
}

$id = $_GET['id'];

$res = $personaggiController->getPersonaggioById($id);

if ($res) {
    $tmpFilePath =  "../../media/tmp/" . uniqid("foto_") . ".jpg";
    file_put_contents($tmpFilePath, $res['foto']);
    $res['foto'] = $tmpFilePath;

    $response = array('success' => true, 'data' => $res);
} else {
    $response = array('success' => false, 'message' => 'Errore di connessione con il server');
}


echo json_encode($response);
