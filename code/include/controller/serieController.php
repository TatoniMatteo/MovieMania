<?php

class SerieController
{
    private $dbConnection;

    public function __construct(Database $db)
    {
        $this->dbConnection = $db;
    }

    public function getAllSeries()
    {
        $query = "SELECT * FROM series";
        $result = mysqli_query($this->dbConnection->getConnection(), $query);

        // Gestisci il risultato della query come desideri
        // ...
    }

    // Altri metodi per il controller delle serie...
}
