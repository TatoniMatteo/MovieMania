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
        $query = "SELECT s.*, IFNULL(ROUND(AVG(r.voto), 1), 0) AS media_voti, 'serie' as tipo
        FROM Serie as s
        LEFT JOIN Recensione as r ON s.id = r.id_serie
        GROUP BY s.id";

        $result = mysqli_query($this->dbConnection->getConnection(), $query);
        $series = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $series[] = $row;
            }
        }
        return $series;
    }

    public function getCategoriesOfSerie($id)
    {
        $query = "SELECT c.categoria, c.colore
        FROM caratterizza
        LEFT JOIN serie as s ON s.id = caratterizza.id_serie
        LEFT JOIN categoria as c ON c.id = caratterizza.id_categoria
        WHERE s.id = $id";

        $result = mysqli_query($this->dbConnection->getConnection(), $query);
        $categories = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $categories[] = $row;
            }
        }
        return $categories;
    }
}
