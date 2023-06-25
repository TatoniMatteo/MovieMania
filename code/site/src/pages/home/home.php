<?php
require_once '../../../../include/config.php';
$config = Config::getInstance();

$filmController = $config->getFilmController();
$allFilms = $filmController->getAllFilms();

include 'home.html';
