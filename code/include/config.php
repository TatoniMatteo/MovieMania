<?php

require_once 'dbm/dbm.php';
require_once 'controller/filmController.php';
require_once 'controller/serieController.php';
require_once 'controller/personaggiController.php';
require_once 'controller/recensioniController.php';
require_once 'controller/utentiController.php';
require_once 'controller/authController.php';

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

    public function getPersonaggiController()
    {
        return new PersonaggiController($this->database);
    }

    public function getRecensioniController()
    {
        return new RecensioniController($this->database);
    }

    public function getUtentiController()
    {
        return new UtentiController($this->database);
    }

    public function getAuthController()
    {
        return new AuthController($this->database);
    }
}
