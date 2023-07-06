<?php

require_once '../../../../include/config.php';
session_start();
$config = Config::getInstance();

$searchController = $config->getSearchController();

$response = array();
if (!isset($_POST['testo']) or !isset($_POST['filtro'])) {
    $response = array('success' => false, 'message' => 'Dati inseriti non validi');
} else {
    $testo = $_POST['testo'];
    $filtro = $_POST['filtro'];

    if (empty(trim($testo)) or empty(trim($filtro))) {
        $response = array('success' => false, 'message' => 'Dati inseriti non validi!');
    } else {
        $res = $searchController->search($testo, $filtro);
        foreach ($res as $result) {
            if (array_key_exists('copertina', $result)) $result['copertina'] = "data:image/jpeg;base64," . base64_encode($result['copertina']);
        }
        $response = array('success' => true, 'result' => $res);
    }
}

header('Content-Type: application/json');
echo json_encode($response);
