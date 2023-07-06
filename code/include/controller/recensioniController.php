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
        WHERE Recensione.id_film = ?
        ORDER BY Recensione.voto DESC
        LIMIT ?, 5";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "ii", $id, $offset);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);
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
        WHERE Recensione.id_serie = ?
        ORDER BY Recensione.voto DESC
        LIMIT ?, 5";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "ii", $id, $offset);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);
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
        WHERE Recensione.id_film = ?";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "i", $id);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);

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
        WHERE Recensione.id_serie = ?";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "i", $id);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);

        if (mysqli_num_rows($result) > 0) {
            $res = mysqli_fetch_array($result);
            return $res['numero_recensioni'];
        } else {
            return null;
        }
    }

    public function getRecesioniByUtente($id)
    {
        $query = "SELECT R.*, COALESCE(F.copertina, S.copertina) AS copertina, COALESCE(F.titolo, S.titolo) AS titolo, COALESCE(F.data_pubblicazione, MIN(Stag.data_pubblicazione)) AS data_pubblicazione
        FROM Recensione R
        LEFT JOIN Film F ON R.id_film = F.id
        LEFT JOIN Serie S ON R.id_serie = S.id
        LEFT JOIN Stagione St ON S.id = St.id_serie
        WHERE R.id_utente = ?
        GROUP BY R.id, F.id, S.id";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "i", $id);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);
        $recensioni = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $recensioni[] = $row;
            }
        }

        return $recensioni;
    }

    public function getRecensione($id_utente, $id_programma, $tipo)
    {
        if ($tipo == "film") {
            $query = "SELECT * FROM recensione
            WHERE id_film = ? AND id_utente = ?";
        } else if ($tipo == "serie") {
            $query = "SELECT * FROM recensione
            WHERE id_serie = ? AND id_utente = ?";
        } else {
            return false;
        }

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "ii", $id_programma, $id_utente);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);
        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_array($result);
        } else {
            return null;
        }
    }

    public function addRecensione($id_utente, $id_programma, $tipo, $titolo, $descrizione, $voto)
    {
        if ($tipo == "film") {
            $query = "INSERT INTO Recensione (titolo, descrizione, voto, id_film, id_serie, id_utente) 
            VALUES (?, ?, ?, ?, null, ?)";
        } else if ($tipo == "serie") {
            $query = "INSERT INTO Recensione (titolo, descrizione, voto, id_film, id_serie, id_utente) 
            VALUES (?, ?, ?, null, ?, ?)";
        } else {
            return false;
        }

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "ssisi", $titolo, $descrizione, $voto, $id_programma, $id_utente);
        return mysqli_stmt_execute($statement);
    }

    public function editRecensione($id_utente, $id_programma,  $tipo, $titolo, $descrizione, $voto)
    {
        if ($tipo == "film") {
            $query = "UPDATE Recensione 
            SET titolo = ?, descrizione = ?, voto = ?
            WHERE id_film = ? AND id_utente = ?";
        } else if ($tipo == "serie") {
            $query = "UPDATE Recensione 
            SET titolo = ?, descrizione = ?, voto = ?
            WHERE id_serie = ? AND id_utente = ?";
        } else {
            return false;
        }

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "ssisi", $titolo, $descrizione, $voto, $id_programma, $id_utente);
        return mysqli_stmt_execute($statement);
    }
}
