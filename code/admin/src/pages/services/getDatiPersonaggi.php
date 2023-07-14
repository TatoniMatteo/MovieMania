<?php
require_once '../../../../include/config.php';
header('Content-Type: application/json');

$config = Config::getInstance();
$statsController = $config->getStatisticheController();

if (!isset($_GET['id']) || !isset($_GET['tipo'])) {
    $response = array('success' => false, 'message' => 'Dati mancanti');
    echo json_encode($response);
    exit();
}

$id = $_GET['id'];
$tipo = $_GET['tipo'];

if ($tipo == 'film') {
    $res = $statsController->getPersonaggiByFilm($id);
} else if ($tipo == 'serie') {
    $res = $statsController->getPersonaggiBySerie($id);
} else {
    $response = array('success' => false, 'message' => 'Dati errati');
    echo json_encode($response);
    exit();
}


if ($res) {
    $response = array('success' => true, 'data' => $res);
} else {
    $response = array('success' => false, 'message' => 'Errore di connessione con il server');
}


echo json_encode($response);
