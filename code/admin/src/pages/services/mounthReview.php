<?php
require_once '../../../../include/config.php';

$config = Config::getInstance();
$statsController = $config->getStatisticheController();

$res = $statsController->getMounthReview();

if ($res) {
    $response = array('success' => true, 'data' => $res);
} else {
    $response = array('success' => false, 'message' => 'Errore di connessione con il server');
}

header('Content-Type: application/json');
echo json_encode($response);
