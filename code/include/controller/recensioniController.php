<?php

class RecensioniController
{
    private $dbConnection;

    public function __construct(Database $db)
    {
        $this->dbConnection = $db;
    }

    public function getRecensioniByFilm($id, $offset)
    {
        $query = "SELECT Recensione.*
        FROM Recensione
        INNER JOIN Utenti ON Recensione.id_utente = Utenti.id
        WHERE Recensione.id_film =" . $id . "
        ORDER BY Recensione.voto DESC
        LIMIT " . $offset . ",5";

        $result = mysqli_query($this->dbConnection->getConnection(), $query);
        $recensioni = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $recensioni[] = $row;
            }
        }
        return $recensioni;
    }

    public function getRecensioniBySerie($id, $offset)
    {
        $query = "SELECT Recensione.*
        FROM Recensione
        INNER JOIN Utenti ON Recensione.id_utente = Utenti.id
        WHERE Recensione.id_serie =" . $id . "
        ORDER BY Recensione.voto DESC
        LIMIT " . $offset . ",5";

        $result = mysqli_query($this->dbConnection->getConnection(), $query);
        $recensioni = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $recensioni[] = $row;
            }
        }
        return $recensioni;
    }

    public function getNumeroRecesioniByFilm($id)
    {
        $query = "SELECT COUNT(*) AS numero_recensioni 
        FROM Recensione
        INNER JOIN Film ON Recensione.id_film = Film.id
        WHERE Recensione.id_film =" . $id;

        $result = mysqli_query($this->dbConnection->getConnection(), $query);

        if (mysqli_num_rows($result) > 0) {
            $res = mysqli_fetch_array($result);
            return $res['numero_recensioni'];
        } else {
            return null;
        }
    }

    public function getNumeroRecesioniBySerie($id)
    {
        $query = "SELECT COUNT(*) AS numero_recensioni 
        FROM Recensione
        INNER JOIN Serie ON Recensione.id_serie = Serie.id
        WHERE Recensione.id_serie =" . $id;

        $result = mysqli_query($this->dbConnection->getConnection(), $query);

        if (mysqli_num_rows($result) > 0) {
            $res = mysqli_fetch_array($result);
            return $res['numero_recensioni'];
        } else {
            return null;
        }
    }


    public function getRecesioniByUtente($id)
    {
        $query = "SELECT R.*, COALESCE(F.copertina, S.copertina) AS copertina, COALESCE(F.titolo, S.titolo) AS titolo, COALESCE(F.data_pubblicazione, MIN(St.data_pubblicazione)) AS data_pubblicazione
        FROM Recensione R
        LEFT JOIN Film F ON R.id_film = F.id
        LEFT JOIN Serie S ON R.id_serie = S.id
        LEFT JOIN Stagione St ON S.id = St.id_serie
        WHERE R.id_utente = " . $id . "
        GROUP BY R.id, F.id, S.id";

        $result = mysqli_query($this->dbConnection->getConnection(), $query);
        $recensioni = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $recensioni[] = $row;
            }
        }
        return $recensioni;
    }
}
