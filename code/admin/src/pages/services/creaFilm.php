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
    !isset($_POST['durata']) ||
    !isset($_POST['data_pubblicazione']) ||
    !isset($_POST['categorie']) ||
    !isset($_POST['produttori']) ||
    !isset($_POST['attori']) ||
    !isset($_POST['membri'])
) {
    echo json_encode(['success' => false, 'message' => 'Dati non corretti!']);
    exit;
}

$titolo = $_POST['titolo'];
$descrizione = $_POST['descrizione'];
$copertina = file_get_contents($_POST['copertina']);
$trailer = $_POST['trailer'];
$durata = $_POST['durata'];
$data = $_POST['data_pubblicazione'];
$filmId = isset($_POST['id']) ? $_POST['id'] : null;
$categorie = json_decode($_POST['categorie'], true);
$produttori = json_decode($_POST['produttori'], true);
$attori = json_decode($_POST['attori'], true);
$membri = json_decode($_POST['membri'], true);

if ($filmId) {
    $response = $createController->aggiornaFilm($filmId, $titolo, $descrizione, $copertina, $trailer, $durata, $data, $categorie, $produttori, $attori, $membri);
} else {
    $response = $createController->creaFilm($titolo, $descrizione, $copertina, $trailer, $durata, $data, $categorie, $produttori, $attori, $membri);
}
echo json_encode($response);
exit;
