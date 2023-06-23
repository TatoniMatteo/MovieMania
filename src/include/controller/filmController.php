<?php

require_once "../dbm/dbm.php";

class FilmController
{
    private $dbConnection;

    public function __construct(Database $db)
    {
        $this->dbConnection = $db;
    }

    public function getAllFilms()
    {
        $query = "SELECT * FROM films";
        $result = mysqli_query($this->dbConnection->getConnection(), $query);

        // Gestisci il risultato della query come desideri
        // ...
    }

    // Altri metodi per il controller dei film...
}
