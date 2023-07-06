<?php

class FilmController
{
    private $dbConnection;

    public function __construct(Database $db)
    {
        $this->dbConnection = $db;
    }

    public function getFilmById($id)
    {
        $query = "SELECT Film.*, IFNULL(ROUND(AVG(Recensione.voto), 1), 0) AS media_voti, IFNULL(COUNT(Recensione.id), 0) AS numero_recensioni
            FROM Film
            LEFT JOIN Recensione ON Film.id = Recensione.id_film
            WHERE Film.id = ?
            GROUP BY Film.id;";

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


    public function getAllFilms($l)
    {
        if ($l > 0) {
            $limit = "LIMIT ?";
        } else {
            $limit = "";
        }

        $query = "SELECT f.*, IFNULL(ROUND(AVG(r.voto), 1), 0) AS media_voti, 'film' as tipo
        FROM Film as f
        LEFT JOIN Recensione as r ON f.id = r.id_film
        GROUP BY f.id 
        ORDER BY f.data_pubblicazione DESC " . $limit;

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "i", $l);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);
        $films = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $films[] = $row;
            }
        }

        return $films;
    }

    public function getCategoriesOfFilm($id)
    {
        $query = "SELECT c.categoria, c.colore
        FROM caratterizza
        LEFT JOIN film as f ON f.id = caratterizza.id_film
        LEFT JOIN categoria as c ON c.id = caratterizza.id_categoria
        WHERE f.id = ?";

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

    public function getLastFilms()
    {
        $query = "SELECT Film.*, IFNULL(ROUND(AVG(Recensione.voto), 1), 0) AS media_voti
        FROM Film
        LEFT JOIN Recensione ON Film.id = Recensione.id_film
        WHERE Film.data_pubblicazione >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)
        GROUP BY Film.id
        LIMIT 10;";

        $result = mysqli_query($this->dbConnection->getConnection(), $query);
        $films = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $films[] = $row;
            }
        }

        return $films;
    }

    public function getBestFilms()
    {
        $query = "SELECT Film.*, IFNULL(ROUND(AVG(Recensione.voto), 1), 0) AS media_voti
        FROM Film
        LEFT JOIN Recensione ON Film.id = Recensione.id_film
        GROUP BY Film.id
        ORDER BY media_voti DESC, Film.data_pubblicazione DESC
        LIMIT 10;";

        $result = mysqli_query($this->dbConnection->getConnection(), $query);
        $films = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $films[] = $row;
            }
        }

        return $films;
    }

    public function getBestReviewedFilms()
    {
        $query = "SELECT Film.*, IFNULL(ROUND(AVG(Recensione.voto), 1), 0) AS media_voti, IFNULL(COUNT(Recensione.id), 0) AS numero_recensioni
        FROM Film
        LEFT JOIN Recensione ON Film.id = Recensione.id_film
        GROUP BY Film.id
        ORDER BY numero_recensioni DESC, Film.data_pubblicazione DESC
        LIMIT 10;";

        $result = mysqli_query($this->dbConnection->getConnection(), $query);
        $films = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $films[] = $row;
            }
        }

        return $films;
    }

    public function getFilmCorrelati($id)
    {
        $query = "SELECT F1.*, COUNT(*) AS categorie_comuni, ROUND(COALESCE(AVG(R.voto), 0),1) AS media_voti
        FROM Film F1
        JOIN Caratterizza C1 ON F1.id = C1.id_film
        JOIN (SELECT C2.id_categoria 
                FROM Caratterizza C2
                WHERE C2.id_film = ?) AS Subquery ON C1.id_categoria = Subquery.id_categoria
        LEFT JOIN Recensione R ON F1.id = R.id_film
        GROUP BY F1.id, F1.titolo
        HAVING categorie_comuni >= 1 AND F1.id <> ?
        ORDER BY categorie_comuni DESC, media_voti DESC
        LIMIT 5;";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "ii", $id, $id);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);
        $films = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $films[] = $row;
            }
        }

        return $films;
    }
}
