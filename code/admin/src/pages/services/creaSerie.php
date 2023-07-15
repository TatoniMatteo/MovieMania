<?php
require_once '../../../../include/config.php';
header('Content-Type: application/json');

$config = Config::getInstance();
$createController = $config->getCreazioneController();

if (
    !isset($_POST['titolo']) ||
    !isset($_POST['descrizione']) ||
    !isset($_POST['copertina']) ||
    !isset($_POST['trailer']) ||
    !isset($_POST['serieFinita']) ||
    !isset($_POST['categorie']) ||
    !isset($_POST['produttori']) ||
    !isset($_POST['attori']) ||
    !isset($_POST['membri']) ||
    !isset($_POST['stagioni'])
) {
    echo json_encode(['success' => false, 'message' => 'Dati non corretti!']);
    exit;
}

$titolo = $_POST['titolo'];
$descrizione = $_POST['descrizione'];
$copertina = file_get_contents($_POST['copertina']);
$trailer = $_POST['trailer'];
$serieFinita = $_POST['serieFinita'];
$serieId = isset($_POST['id']) ? $_POST['id'] : null;
$categorie = json_decode($_POST['categorie'], true);
$produttori = json_decode($_POST['produttori'], true);
$attori = json_decode($_POST['attori'], true);
$membri = json_decode($_POST['membri'], true);
$stagioni = json_decode($_POST['stagioni'], true);

foreach ($stagioni as &$stagione) {
    $stagione['copertina'] = file_get_contents($stagione['copertina']);
}
unset($stagione);


if ($serieId) {
    $response = $createController->aggiornaSerie($serieId, $titolo, $descrizione, $copertina, $trailer, $serieFinita, $categorie, $produttori, $attori, $membri, $stagioni);
} else {
    $response = $createController->creaSerie($titolo, $descrizione, $copertina, $trailer, $serieFinita, $categorie, $produttori, $attori, $membri, $stagioni);
}
echo json_encode($response);
exit;
