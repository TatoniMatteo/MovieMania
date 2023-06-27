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

    public function getLastSeries()
    {
        $query = "SELECT Serie.*, IFNULL(ROUND(AVG(Recensione.voto), 1), 0) AS media_voti
        FROM Serie
        LEFT JOIN Stagione ON Serie.id = Stagione.id_serie
        LEFT JOIN Recensione ON Serie.id = Recensione.id_serie
        WHERE Stagione.data_pubblicazione >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)
        AND Stagione.data_pubblicazione <= CURDATE()
        GROUP BY Serie.id";

        $result = mysqli_query($this->dbConnection->getConnection(), $query);
        $series = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $series[] = $row;
            }
        }
        return $series;
    }

    public function getBestSeries()
    {
        $query = "SELECT Serie.*,
        (SELECT IFNULL(ROUND(AVG(Recensione.voto), 1), 0)
            FROM Recensione
            WHERE Recensione.id_serie = Serie.id
        ) AS media_voti
        FROM Serie
        
        INNER JOIN (SELECT id_serie,
                        MAX(data_pubblicazione) AS ultima_data_pubblicazione
                        FROM Stagione
                        GROUP BY id_serie
                    ) AS ultima_stagione ON Serie.id = ultima_stagione.id_serie
        
        INNER JOIN Stagione ON ultima_stagione.id_serie = Stagione.id_serie
            AND ultima_stagione.ultima_data_pubblicazione = Stagione.data_pubblicazione
        
        ORDER BY media_voti DESC, ultima_data_pubblicazione DESC
        LIMIT 10;";

        $result = mysqli_query($this->dbConnection->getConnection(), $query);
        $series = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $series[] = $row;
            }
        }
        return $series;
    }

    public function getBestReviewedSeries()
    {
        $query = "SELECT Serie.*,
        (SELECT IFNULL(ROUND(AVG(Recensione.voto), 1), 0)
            FROM Recensione
            WHERE Recensione.id_serie = Serie.id
        ) AS media_voti,
        (SELECT COUNT(*)
            FROM Recensione
            WHERE Recensione.id_serie = Serie.id
        ) AS numero_recensioni
        FROM Serie
        
        INNER JOIN (SELECT id_serie,
                        MAX(data_pubblicazione) AS ultima_data_pubblicazione
                        FROM Stagione
                        GROUP BY id_serie
                    ) AS ultima_stagione ON Serie.id = ultima_stagione.id_serie
        
        INNER JOIN Stagione ON ultima_stagione.id_serie = Stagione.id_serie
            AND ultima_stagione.ultima_data_pubblicazione = Stagione.data_pubblicazione
        
        ORDER BY numero_recensioni DESC, ultima_data_pubblicazione DESC
        LIMIT 10;";

        $result = mysqli_query($this->dbConnection->getConnection(), $query);
        $series = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $series[] = $row;
            }
        }
        return $series;
    }
}
