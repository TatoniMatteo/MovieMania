<?php
$cartella = '../../media/tmp';
$files = glob($cartella . '/*');

foreach ($files as $file) {
    if (is_file($file)) {
        unlink($file);
    }
}
