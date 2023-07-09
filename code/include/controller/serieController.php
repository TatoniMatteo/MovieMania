<?php

class SerieController
{
    private $dbConnection;

    public function __construct(Database $db)
    {
        $this->dbConnection = $db;
    }

    public function getSerieById($id)
    {
        $query = "SELECT S.*, MIN(St.data_pubblicazione) AS inizio_serie, ROUND(COALESCE(AVG(R.voto), 0), 1) AS media_voti,
        CASE
            WHEN S.conclusa = 1 THEN MAX(St.data_pubblicazione)
        END AS fine_serie
    FROM Serie S
    LEFT JOIN Stagione St ON S.id = St.id_serie
    LEFT JOIN Recensione R ON S.id = R.id_serie
    WHERE S.id = ?";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "i", $id);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);

        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        } else {
            return null;
        }
    }

    public function getMainSeries($l)
    {
        if ($l > 0) {
            $limit = "LIMIT " . $l;
        } else {
            $limit = "";
        }

        $query = "SELECT s.*, IFNULL(ROUND(AVG(r.voto), 1), 0) AS media_voti, 'serie' as tipo
    FROM Serie as s
    LEFT JOIN Recensione as r ON s.id = r.id_serie
    LEFT JOIN Stagione as st ON s.id = st.id_serie
    GROUP BY s.id
    ORDER BY MAX(st.data_pubblicazione) DESC, media_voti " . $limit;

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
    WHERE s.id = ?";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "i", $id);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);
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

    public function getAllSeasonBySerieId($id)
    {
        $query = "SELECT *
    FROM Stagione
    WHERE id_serie = ?
    ORDER BY numero_stagione";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "i", $id);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);
        $seasons = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $seasons[] = $row;
            }
        }
        return $seasons;
    }

    public function getSerieCorrelate($id)
    {
        $query = "SELECT S1.*, COUNT(*) AS categorie_comuni, ROUND(COALESCE(AVG(R.voto), 0),1) AS media_voti, MIN(St.data_pubblicazione) AS inizio_serie
        FROM Serie S1
        LEFT JOIN Stagione St ON S1.id = St.id_serie
        JOIN Caratterizza C1 ON S1.id = C1.id_serie
        JOIN (SELECT C2.id_categoria 
                FROM Caratterizza C2
                WHERE C2.id_serie = ?) AS Subquery ON C1.id_categoria = Subquery.id_categoria
        LEFT JOIN Recensione R ON S1.id = R.id_serie
        GROUP BY S1.id, S1.titolo
        HAVING categorie_comuni >= 1 AND S1.id <> ?
        ORDER BY categorie_comuni DESC, media_voti DESC
        LIMIT 5;";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "ii", $id, $id);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);
        $series = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $series[] = $row;
            }
        }
        return $series;
    }
}
