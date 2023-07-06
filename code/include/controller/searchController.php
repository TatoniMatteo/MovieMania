<?php

class SearchController
{
    private $dbConnection;

    public function __construct(Database $db)
    {
        $this->dbConnection = $db;
    }

    public function search($testo, $filtro)
    {
        $query = "SELECT *
            FROM (
                SELECT 'film' AS tipo, Film.id, Film.titolo, Film.descrizione, Film.copertina, IFNULL(ROUND(AVG(Recensione.voto), 1), 0) AS media_voti
                FROM Film
                LEFT JOIN Recensione ON Film.id = Recensione.id_film
                WHERE (Film.titolo LIKE CONCAT('%', ?, '%') OR Film.descrizione LIKE CONCAT('%', ?, '%'))
                    OR SOUNDEX(Film.titolo) = SOUNDEX(?)
                GROUP BY Film.id
                
                UNION ALL
                
                SELECT 'serie' AS tipo, Serie.id, Serie.titolo, Serie.descrizione, Serie.copertina, IFNULL(ROUND(AVG(Recensione.voto), 1), 0) AS media_voti
                FROM Serie
                LEFT JOIN Recensione ON Serie.id = Recensione.id_serie
                WHERE (Serie.titolo LIKE CONCAT('%', ?, '%') OR Serie.descrizione LIKE CONCAT('%', ?, '%'))
                    OR SOUNDEX(Serie.titolo) = SOUNDEX(?)
                GROUP BY Serie.id 

                UNION ALL
                
                SELECT 'celebrità' AS tipo, id, nome, cognome, biografia, foto
                FROM Personaggi
                WHERE (nome LIKE CONCAT('%', ?, '%') OR cognome LIKE CONCAT('%', ?, '%'))
                    OR SOUNDEX(nome) = SOUNDEX(?)
                    OR SOUNDEX(cognome) = SOUNDEX(?)
            ) AS risultati
            WHERE (
                (? = 'film e serie' AND (tipo = 'film' OR tipo = 'serie'))
                OR (? = 'solo film' AND tipo = 'film')
                OR (? = 'solo serie' AND tipo = 'serie')
                OR (? = 'celebrità' AND tipo = 'celebrità')
            )";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "ssssssssssssss", $testo, $testo, $testo, $testo, $testo, $testo, $testo, $testo, $testo, $testo, $filtro, $filtro, $filtro, $filtro);
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
}
