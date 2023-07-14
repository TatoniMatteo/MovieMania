<?php
require_once '../../../../include/config.php';
header('Content-Type: application/json');

$config = Config::getInstance();
$statsController = $config->getStatisticheController();

if (!isset($_GET['id'])) {
    $response = array('success' => false, 'message' => 'Dati mancanti');
    echo json_encode($response);
    exit();
}

$id = $_GET['id'];

$stagioni = $statsController->getStagioniBySerie($id);

if ($stagioni) {
    if (!file_exists('../../media/tmp/')) {
        mkdir('../../media/tmp/', 0777, true);
    }

    $modifiedStagioni = array();

    foreach ($stagioni as $stagione) {
        $tmpFilePath = '../../media/tmp/' . uniqid("copertina_") . ".jpg";
        file_put_contents($tmpFilePath, $stagione['copertina']);
        $stagione['copertina'] = $tmpFilePath;
        $modifiedStagioni[] = $stagione;
    }

    $response = array('success' => true, 'data' => $modifiedStagioni);
} else {
    $response = array('success' => false, 'message' => 'Errore di connessione con il server');
}

echo json_encode($response);
