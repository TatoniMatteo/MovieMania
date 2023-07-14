<?php
require_once '../../../../include/config.php';
header('Content-Type: application/json');

$config = Config::getInstance();
$filmController = $config->getFilmController();
$serieController = $config->getSerieController();

if (!isset($_GET['id']) || !isset($_GET['tipo'])) {
    $response = array('success' => false, 'message' => 'Dati mancanti');
    echo json_encode($response);
    exit();
}

$id = $_GET['id'];
$tipo = $_GET['tipo'];

if ($tipo == 'film') {
    $res = $filmController->getFilmById($id);
} else if ($tipo == 'serie') {
    $res = $serieController->getSerieById($id);
} else {
    $response = array('success' => false, 'message' => 'Dati errati');
    echo json_encode($response);
    exit();
}


if ($res) {
    if (!file_exists('../../media/tmp/')) {
        mkdir('../../media/tmp/', 0777, true);
    }

    $tmpFilePath = '../../media/tmp/' . uniqid("copertina_") . ".jpg";

    file_put_contents($tmpFilePath, $res['copertina']);
    $res['copertina'] = $tmpFilePath;

    $response = array('success' => true, 'data' => $res);
} else {
    $response = array('success' => false, 'message' => 'Errore di connessione con il server');
}


echo json_encode($response);
