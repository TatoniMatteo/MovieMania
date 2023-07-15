<?php
require_once '../../../../include/config.php';
header('Content-Type: application/json');

$config = Config::getInstance();
$utentiController = $config->getUtentiController();

if (
    !isset($_POST['id']) || !isset($_POST['permessi'])
) {
    echo json_encode(['success' => false, 'message' => 'Dati non corretti!']);
    exit;
}

$id = $_POST['id'];
$permessiString = $_POST['permessi'];
$permessi = $permessiString ? explode(",", $_POST['permessi']) : array();

$response = $utentiController->modificaPermessi($id, $permessi);
echo json_encode($response);
exit;
