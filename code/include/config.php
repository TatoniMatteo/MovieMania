<?php

require_once 'dbm/dbm.php';
require_once 'controller/filmController.php';
require_once 'controller/serieController.php';

class Config
{
    private static $instance;
    private $database;

    private function __construct()
    {
        $this->database = new Database();
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Config();
        }
        return self::$instance;
    }

    public function getFilmController()
    {
        return new FilmController($this->database);
    }

    public function getSerieController()
    {
        return new SerieController($this->database);
    }

    private function onClose()
    {
        $this->database->closeConnection();
    }
}

/* 

COME USARE?

$filmController = Config::getFilmController();
$serieController = Config::getSerieController();

// Utilizza i controller per eseguire le operazioni desiderate
$filmController->getAllFilms();
$serieController->getAllSeries();
*/
