<?php
require_once '../../../../include/config.php';
header('Content-Type: application/json');

$config = Config::getInstance();
$createController = $config->getCreazioneController();

if (
    !isset($_POST['nome']) ||
    !isset($_POST['cognome']) ||
    !isset($_POST['biografia']) ||
    !isset($_POST['data_nascita']) ||
    !isset($_POST['nazionalita']) ||
    !isset($_POST['altezza']) ||
    !isset($_POST['foto'])
) {
    echo json_encode(['success' => false, 'message' => 'Dati non corretti!']);
    exit;
}

$nome = $_POST['nome'];
$cognome = $_POST['cognome'];
$foto = file_get_contents($_POST['foto']);
$biografia = $_POST['biografia'];
$nascita = $_POST['data_nascita'];
$nazionalita = $_POST['nazionalita'];
$altezza = $_POST['altezza'];
$personaggioId = isset($_POST['id']) ? $_POST['id'] : null;


if ($personaggioId) {
    $response = $createController->aggiornaPersonaggio($personaggioId, $nome, $cognome, $foto, $biografia, $nascita, $nazionalita, $altezza);
} else {
    $response = $createController->creaPersonaggio($nome, $cognome, $foto, $biografia, $nascita, $nazionalita, $altezza);
}
echo json_encode($response);
exit;
