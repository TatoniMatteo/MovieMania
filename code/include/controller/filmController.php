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
        WHERE Film.id = " . $id . "
        GROUP BY Film.id;";
        $result = mysqli_query($this->dbConnection->getConnection(), $query);

        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        } else {
            return null;
        }
    }

    public function getAllFilms()
    {
        $query = "SELECT f.*, IFNULL(ROUND(AVG(r.voto), 1), 0) AS media_voti, 'film' as tipo
        FROM Film as f
        LEFT JOIN Recensione as r ON f.id = r.id_film
        GROUP BY f.id";

        $result = mysqli_query($this->dbConnection->getConnection(), $query);
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
        WHERE f.id = $id";

        $result = mysqli_query($this->dbConnection->getConnection(), $query);
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
}
