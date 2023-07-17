<?php
require_once '../../../../include/config.php';
header('Content-Type: application/json');

// Controlla se il file è stato caricato correttamente
if ($_FILES['foto']['error'] !== UPLOAD_ERR_OK || !isset($_POST['altezza']) || !isset($_POST['larghezza'])) {
    echo json_encode(['success' => false, 'message' => 'Errore nel caricamento dell\'immagine']);
    exit;
}

$altezza = $_POST['altezza'];
$larghezza = $_POST['larghezza'];
$rapporto = $larghezza / $altezza;

$tmp_name = $_FILES['foto']['tmp_name'];
$extension = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));

if ($extension === 'jpeg' || $extension === 'jpg') {
    $source_image = imagecreatefromjpeg($tmp_name);
} elseif ($extension === 'png') {
    $source_image = imagecreatefrompng($tmp_name);
} else {
    echo json_encode(['success' => false, 'message' => 'Formato immagine non supportato. Sono consentiti solo file JPEG e PNG.']);
    exit;
}

$source_width = imagesx($source_image);
$source_height = imagesy($source_image);
$rapportoOriginale = $source_width / $source_height;

$cropped_image = $rapporto == $rapportoOriginale ? $source_image : null;

if ($rapporto > $rapportoOriginale) {
    $nuovaAltezza = $source_width * ($rapporto ** -1);
    $cropped_image = imagecrop($source_image, [
        'x' => 0,
        'y' => ($source_height - $nuovaAltezza) / 2,
        'width' => $source_width,
        'height' => $nuovaAltezza
    ]);
} else if ($rapporto < $rapportoOriginale) {
    $nuovaLarghezza = $source_height * $rapporto;
    $cropped_image = imagecrop($source_image, [
        'x' => ($source_width - $nuovaLarghezza) / 2,
        'y' => 0,
        'width' => $nuovaLarghezza,
        'height' => $source_height
    ]);
}

if (!$cropped_image) {
    echo json_encode(['success' => false, 'message' => 'Errore nel ritaglio dell\'immagine']);
    exit;
}

$resized_image = imagescale($cropped_image, $larghezza, $altezza);

$outputFilename = "../../media/tmp/" . uniqid("copertina_") . ".jpg";

if ($extension === 'jpeg' || $extension === 'jpg') {
    $success = imagejpeg($resized_image, $outputFilename);
} elseif ($extension === 'png') {
    $success = imagepng($resized_image, $outputFilename);
} else {
    $success = false;
}

imagedestroy($source_image);
imagedestroy($cropped_image);
imagedestroy($resized_image);

if ($success) {
    echo json_encode(['success' => true, 'path' => $outputFilename]);
} else {
    echo json_encode(['success' => false, 'message' => 'Problemi con la connessione al server']);
}
