<?php

class SearchController
{
    private $dbConnection;

    public function __construct(Database $db)
    {
        $this->dbConnection = $db;
    }

    public function search($testo, $filtro, $offset, $limit, $ordinamento, $categorie)
    {
        if ($filtro === 'celebrita') {
            return $this->searchCelebrita($testo, $offset, $limit, $ordinamento, $categorie);
        } else {
            return $this->searchFilmSerie($testo, $filtro, $offset, $limit, $ordinamento, $categorie);
        }
    }

    public function searchFilmSerie($testo, $filtro, $offset, $limit, $ordinamento, $generi)
    {
        $query = "SELECT *
        FROM (
            SELECT 'film' AS tipo, Film.id, Film.titolo, Film.descrizione, Film.copertina, Film.data_pubblicazione, IFNULL(ROUND(AVG(Recensione.voto), 1), 0) AS media_voti, IFNULL(COUNT(Recensione.id), 0) AS numero_recensioni
            FROM Film
            LEFT JOIN Recensione ON Film.id = Recensione.id_film
            LEFT JOIN Caratterizza CF ON Film.id = CF.id_film
            WHERE (Film.titolo LIKE CONCAT('%', ?, '%') OR Film.descrizione LIKE CONCAT('%', ?, '%')
                OR SOUNDEX(Film.titolo) = SOUNDEX(?))
                " . (count($generi) > 0 ? "AND CF.id_categoria IN (" . implode(",", $generi) . ")" : "") . "
            GROUP BY Film.id

            UNION ALL

            SELECT 'serie' AS tipo, Serie.id, Serie.titolo, Serie.descrizione, Serie.copertina, MAX(St.data_pubblicazione) AS data_pubblicazione, IFNULL(ROUND(AVG(Recensione.voto), 1), 0) AS media_voti, IFNULL(COUNT(Recensione.id), 0) AS numero_recensioni
            FROM Serie
            LEFT JOIN Recensione ON Serie.id = Recensione.id_serie
            LEFT JOIN Stagione St ON Serie.id = St.id_serie
            LEFT JOIN Caratterizza CS ON Serie.id = CS.id_serie
            WHERE (Serie.titolo LIKE CONCAT('%', ?, '%') OR Serie.descrizione LIKE CONCAT('%', ?, '%')
                OR SOUNDEX(Serie.titolo) = SOUNDEX(?))
                " . ($generi ? "AND CS.id_categoria IN (" . implode(",", $generi) . ")" : "") . "
            GROUP BY Serie.id 
        ) AS risultati
        WHERE (
            (? = 'film e serie' AND (tipo = 'film' OR tipo = 'serie'))
            OR (? = 'solo film' AND tipo = 'film')
            OR (? = 'solo serie' AND tipo = 'serie')
        )
        ORDER BY ";

        switch ($ordinamento) {
            case 0:
                $query .= "risultati.numero_recensioni DESC";
                break;
            case 1:
                $query .= "risultati.numero_recensioni ASC";
                break;
            case 2:
                $query .= "risultati.media_voti DESC";
                break;
            case 3:
                $query .= "risultati.media_voti ASC";
                break;
            case 4:
                $query .= "risultati.data_pubblicazione DESC";
                break;
            case 5:
                $query .= "risultati.data_pubblicazione ASC";
                break;
        }

        $query .= " LIMIT ?, ?";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "sssssssssii", $testo, $testo, $testo, $testo, $testo, $testo, $filtro, $filtro, $filtro, $offset, $limit);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);
        $results = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $results[] = $row;
            }
        }
        return $results;
    }

    public function searchCelebrita($testo, $offset, $limit, $ordinamento, $ruoli)
    {
        $query = "SELECT 'celebrità' AS tipo, Personaggi.id, Personaggi.nome, Personaggi.cognome, Personaggi.foto, Personaggi.nazionalita
            FROM Personaggi
            JOIN Partecipa ON Personaggi.id = Partecipa.id_Personaggio
            WHERE (Personaggi.nome LIKE CONCAT('%', ?, '%') OR Personaggi.cognome LIKE CONCAT('%', ?, '%')
                OR SOUNDEX(Personaggi.nome) = SOUNDEX(?)
                OR SOUNDEX(Personaggi.cognome) = SOUNDEX(?))
                " . ($ruoli ? "AND Partecipa.ruolo IN (" . implode(",", $ruoli) . ")" : "") . "
            GROUP BY Personaggi.id
            ORDER BY ";

        switch ($ordinamento) {
            case 0:
                $query .= "nome, cognome";
                break;
            case 1:
                $query .= "nome DESC, cognome DESC";
                break;
        }

        $query .= " LIMIT ?, ?";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "ssssii", $testo, $testo, $testo, $testo, $offset, $limit);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);
        $results = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $results[] = $row;
            }
        }
        return $results;
    }

    public function countSearchResults($testo, $filtro, $generi)
    {
        $query = "SELECT COUNT(*) AS total_count
        FROM (
            SELECT 'film' AS tipo, Film.id, Film.titolo, Film.descrizione, Film.copertina, Film.data_pubblicazione, IFNULL(ROUND(AVG(Recensione.voto), 1), 0) AS media_voti, IFNULL(COUNT(Recensione.id), 0) AS numero_recensioni
            FROM Film
            LEFT JOIN Recensione ON Film.id = Recensione.id_film
            LEFT JOIN Caratterizza CF ON Film.id = CF.id_film
            WHERE (Film.titolo LIKE CONCAT('%', ?, '%') OR Film.descrizione LIKE CONCAT('%', ?, '%')
                OR SOUNDEX(Film.titolo) = SOUNDEX(?))
                " . (count($generi) > 0 ? "AND CF.id_categoria IN (" . implode(",", $generi) . ")" : "") . "
            GROUP BY Film.id
    
            UNION ALL
    
            SELECT 'serie' AS tipo, Serie.id, Serie.titolo, Serie.descrizione, Serie.copertina, MAX(St.data_pubblicazione) AS data_pubblicazione, IFNULL(ROUND(AVG(Recensione.voto), 1), 0) AS media_voti, IFNULL(COUNT(Recensione.id), 0) AS numero_recensioni
            FROM Serie
            LEFT JOIN Recensione ON Serie.id = Recensione.id_serie
            LEFT JOIN Stagione St ON Serie.id = St.id_serie
            LEFT JOIN Caratterizza CS ON Serie.id = CS.id_serie
            WHERE (Serie.titolo LIKE CONCAT('%', ?, '%') OR Serie.descrizione LIKE CONCAT('%', ?, '%')
                OR SOUNDEX(Serie.titolo) = SOUNDEX(?))
                " . ($generi ? "AND CS.id_categoria IN (" . implode(",", $generi) . ")" : "") . "
            GROUP BY Serie.id 
        ) AS risultati
        WHERE (
            (? = 'film e serie' AND (tipo = 'film' OR tipo = 'serie'))
            OR (? = 'solo film' AND tipo = 'film')
            OR (? = 'solo serie' AND tipo = 'serie')
        )";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "sssssssss", $testo, $testo, $testo, $testo, $testo, $testo, $filtro, $filtro, $filtro);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);
        $row = mysqli_fetch_assoc($result);

        return $row['total_count'];
    }

    public function countCelebritaResults($testo, $ruoli)
    {
        $query = "SELECT COUNT(*) AS total_count
        FROM( SELECT Personaggi.id 
        FROM Personaggi
        JOIN Partecipa ON Personaggi.id = Partecipa.id_Personaggio
        WHERE (Personaggi.nome LIKE CONCAT('%', ?, '%') OR Personaggi.cognome LIKE CONCAT('%', ?, '%')
            OR SOUNDEX(Personaggi.nome) = SOUNDEX(?)
            OR SOUNDEX(Personaggi.cognome) = SOUNDEX(?))
            " . ($ruoli ? "AND Partecipa.ruolo IN (" . implode(",", $ruoli) . ")" : "") . "
        GROUP BY Personaggi.id) as result";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "ssss", $testo, $testo, $testo, $testo);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);
        $row = mysqli_fetch_assoc($result);

        return $row['total_count'];
    }


    public function getAllCategorie()
    {
        $query = "SELECT * FROM Categoria";

        $result = mysqli_query($this->dbConnection->getConnection(), $query);
        $categorie = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $categorie[] = $row;
            }
        }
        return $categorie;
    }

    public function getAllRuoli()
    {
        $query = "SELECT * FROM Ruolo";

        $result = mysqli_query($this->dbConnection->getConnection(), $query);
        $ruoli = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $ruoli[] = $row;
            }
        }
        return $ruoli;
    }
}
