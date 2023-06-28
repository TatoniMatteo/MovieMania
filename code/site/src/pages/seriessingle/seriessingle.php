<?php

require_once '../../../../include/config.php';

$config = Config::getInstance();

$serieController = $config->getSerieController();
$personaggiController = $config->getPersonaggiController();
$recensioniController = $config->getRecensioniController();
$utentiController = $config->getUtentiController();


if (!isset($_GET['id'])) {
    include '../service/404.html';
} else {
    $serieId = $_GET['id'];
    $serie = $serieController->getSerieByID($serieId);
    if ($serie == null) {
        include '../service/404.html';
    } else {
        $stagioni = $serieController->getAllSeasonBySerieId($serieId);
        $ultima_stagione = $stagioni[0];
        $categorie = $serieController->getCategoriesOfSerie($serieId);
        $personaggi = $personaggiController->getPersonaggiBySerie($serieId);
        $numero_recensioni = $recensioniController->getNumeroRecesioniBySerie($serieId);
        $serie_correlate = $serieController->getSerieCorrelate($serieId);
        include 'seriessingle.html';
    }
}
