<?php

class PersonaggiController
{
    private $dbConnection;

    public function __construct(Database $db)
    {
        $this->dbConnection = $db;
    }

    public function getPersonaggioById($id)
    {
        $query = "SELECT Personaggi.*
        FROM Personaggi
        WHERE Personaggi.id = ?";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "i", $id);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);

        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }

        return null;
    }

    public function getPersonaggiByFilm($id)
    {
        $query = "SELECT Personaggi.*, Ruolo.ruolo, Partecipa.star, Partecipa.interpreta
        FROM Partecipa
        INNER JOIN Personaggi ON Partecipa.id_personaggio = Personaggi.id
        INNER JOIN Ruolo ON Partecipa.ruolo = Ruolo.id
        WHERE Partecipa.id_film = ?";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "i", $id);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);
        $personaggi = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $personaggi[] = $row;
            }
        }

        return $personaggi;
    }

    public function getPersonaggiBySerie($id)
    {
        $query = "SELECT Personaggi.*, Ruolo.ruolo, Partecipa.star, Partecipa.interpreta
        FROM Partecipa
        INNER JOIN Personaggi ON Partecipa.id_personaggio = Personaggi.id
        INNER JOIN Ruolo ON Partecipa.ruolo = Ruolo.id
        WHERE Partecipa.id_serie = ?";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "i", $id);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);
        $personaggi = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $personaggi[] = $row;
            }
        }

        return $personaggi;
    }

    public function getFilmographyById($id)
    {
        $query = "SELECT 'Film' AS tipo, Film.id, Film.titolo, Film.copertina, Partecipa.interpreta, Ruolo.ruolo
        FROM Film
        JOIN Partecipa ON Film.id = Partecipa.id_film
        JOIN Personaggi ON Partecipa.id_personaggio = Personaggi.id
        JOIN Ruolo ON Ruolo.id = Partecipa.ruolo
        WHERE Personaggi.id = ?
        
        UNION ALL
 
        SELECT 'Serie' AS tipo, Serie.id, Serie.titolo, Serie.copertina, Partecipa.interpreta, Ruolo.ruolo
        FROM Serie
        JOIN Partecipa ON Serie.id = Partecipa.id_serie
        JOIN Personaggi ON Partecipa.id_personaggio = Personaggi.id
        JOIN Ruolo ON Ruolo.id = Partecipa.ruolo
        WHERE Personaggi.id = ?";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "ii", $id, $id);
        mysqli_stmt_execute($statement);

        $result =  mysqli_stmt_get_result($statement);
        $programmi = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $programmi[] = $row;
            }
        }

        return $programmi;
    }

    public function getRuoliInterpretati($id)
    {
        $query = "SELECT R.ruolo
        FROM Ruolo R
        JOIN Partecipa P ON R.id = P.ruolo
        WHERE P.id_personaggio = ?";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "i", $id);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);
        $ruoli = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $ruoli[] = $row['ruolo'];
            }
        }

        return $ruoli;
    }

    public function getStarinEvidenza()
    {
        $query = "SELECT P.*, Par.interpreta
        FROM Personaggi P
        JOIN Partecipa Par ON P.id = Par.id_personaggio
        LEFT JOIN Film F ON Par.id_film = F.id
        LEFT JOIN Stagione S ON Par.id_serie = S.id_serie
        WHERE Par.star = 1
          AND (Par.id_film IS NOT NULL OR
               (Par.id_serie IS NOT NULL AND S.numero_stagione = (SELECT MAX(numero_stagione) FROM Stagione)))
        ORDER BY COALESCE(F.data_pubblicazione, S.data_pubblicazione) DESC
        LIMIT 6";

        $result = mysqli_query($this->dbConnection->getConnection(), $query);
        $personaggi = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $personaggi[] = $row;
            }
        }

        return $personaggi;
    }
}
