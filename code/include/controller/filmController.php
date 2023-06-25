<?php

class FilmController
{
    private $dbConnection;

    public function __construct(Database $db)
    {
        $this->dbConnection = $db;
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
}
