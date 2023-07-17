<?php
require_once '../../../../include/config.php';
session_start();
header('Content-Type: application/json');

// Controlla se il file è stato caricato correttamente
if ($_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'message' => 'Errore nel caricamento dell\'immagine']);
    exit;
}

$id_utente = $_SESSION['utente'];
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

// Ritaglio dell'immagine in formato quadrato
$source_width = imagesx($source_image);
$source_height = imagesy($source_image);
$crop_size = min($source_width, $source_height);
$cropped_image = imagecrop($source_image, [
    'x' => ($source_width - $crop_size) / 2,
    'y' => ($source_height - $crop_size) / 2,
    'width' => $crop_size,
    'height' => $crop_size
]);

// Ridimensionamento dell'immagine a 300x300
$resized_image = imagescale($cropped_image, 300, 300);

// Conversione dell'immagine in formato base64
ob_start();
if ($extension === 'jpeg' || $extension === 'jpg') {
    imagejpeg($resized_image);
} elseif ($extension === 'png') {
    imagepng($resized_image);
}
$image_data = ob_get_contents();
ob_end_clean();

$res = Config::getInstance()->getUtentiController()->updateFoto($id_utente, $image_data);
imagedestroy($source_image);
imagedestroy($cropped_image);
imagedestroy($resized_image);

if ($res) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Problemi con la connessione al server']);
}
