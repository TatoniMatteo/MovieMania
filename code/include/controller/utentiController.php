<?php

class UtentiController
{
    private $dbConnection;

    public function __construct(Database $db)
    {
        $this->dbConnection = $db;
    }

    public function getUtenteById($id)
    {
        $query = "SELECT Utenti.* 
    FROM Utenti
    WHERE Utenti.id = ?";

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

    public function getPreferiti($id)
    {
        $query = "SELECT ROUND(IFNULL(AVG(R.voto), 0), 1) AS media_voti, 'film' AS tipo, F.*
    FROM Film F
    LEFT JOIN Preferiti P ON F.id = P.id_film
    LEFT JOIN Recensione R ON F.id = R.id_film
    WHERE P.id_utente = ?
    GROUP BY F.id";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "i", $id);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);
        $film = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $film[] = $row;
            }
        }

        $query = "SELECT ROUND(IFNULL(AVG(R.voto), 0), 1) AS media_voti, MIN(St.data_pubblicazione) AS data_pubblicazione, COUNT(St.id) AS numero_stagioni, 'serie' AS tipo, S.*
    FROM Serie S
    LEFT JOIN Preferiti P ON S.id = P.id_serie
    LEFT JOIN Recensione R ON S.id = R.id_serie
    LEFT JOIN Stagione St ON St.id_serie = P.id_serie
    WHERE P.id_utente = ?
    GROUP BY S.id";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "i", $id);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);
        $serie = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $serie[] = $row;
            }
        }

        $preferiti = array_merge($film, $serie);

        function compareByDataPubblicazione($a, $b)
        {
            if ($a['data_pubblicazione'] == $b['data_pubblicazione']) {
                return 0;
            }
            return ($a['data_pubblicazione'] > $b['data_pubblicazione']) ? -1 : 1;
        }
        usort($preferiti, 'compareByDataPubblicazione');
        return $preferiti;
    }

    public function updateFoto($id, $foto)
    {
        $query = "UPDATE utenti
    SET foto = ?
    WHERE id = ?";

        $stmt = $this->dbConnection->getConnection()->prepare($query);
        $stmt->bind_param('ss', $foto, $id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $res = true;
        } else {
            $res = false;
        }
        $stmt->close();
        return $res;
    }

    public function updateDati($id, $username, $email, $nome, $cognome)
    {
        $modifiche = array();
        $types = "";
        $params = array();

        if ($username != "") {
            $modifiche[] = 'username = ?';
            $types .= "s";
            $params[] = $username;
        }
        if ($email != "") {
            $modifiche[] = 'email = ?';
            $types .= "s";
            $params[] = $email;
        }
        if ($nome != "") {
            $modifiche[] = 'nome = ?';
            $types .= "s";
            $params[] = $nome;
        }
        if ($cognome != "") {
            $modifiche[] = 'cognome = ?';
            $types .= "s";
            $params[] = $cognome;
        }

        $query = "UPDATE utenti
        SET " . implode(', ', $modifiche) . "
        WHERE id = ?";

        $types .= "i";
        $params[] = $id;

        $stmt = $this->dbConnection->getConnection()->prepare($query);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }

    public function updatePassword($id, $old, $new)
    {
        $query = "SELECT Utenti.password 
    FROM Utenti
    WHERE Utenti.id = ?";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "i", $id);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);

        if (mysqli_num_rows($result) > 0) {
            $check =  mysqli_fetch_assoc($result)['password'];
        } else {
            return false;
        }

        if ($old == $check) {
            $query = "UPDATE utenti
        SET password = ?
        WHERE id = ?";

            $stmt = $this->dbConnection->getConnection()->prepare($query);
            $stmt->bind_param('si', $new, $id);
            $stmt->execute();

            return $stmt->affected_rows > 0;
        }
        return false;
    }

    public function addPreferito($id_utente, $id_programma, $tipo)
    {
        if ($tipo == 'film') {
            $query = "INSERT INTO Preferiti (id_film, id_utente)
        VALUES (?, ?)";
        } else {
            $query = "INSERT INTO Preferiti (id_serie, id_utente)
        VALUES (?, ?)";
        }

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "ii", $id_programma, $id_utente);
        mysqli_stmt_execute($statement);

        return mysqli_stmt_affected_rows($statement) > 0;
    }

    public function removePreferito($id_utente, $id_programma, $tipo)
    {
        if ($tipo == 'film') {
            $query = "DELETE FROM Preferiti
        WHERE id_film = ? AND id_utente = ?";
        } else {
            $query = "DELETE FROM Preferiti
        WHERE id_serie = ? AND id_utente = ?";
        }

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "ii", $id_programma, $id_utente);
        mysqli_stmt_execute($statement);

        return mysqli_stmt_affected_rows($statement) > 0;
    }

    public function isPreferito($id_utente, $id_programma, $tipo)
    {
        if ($tipo == 'film') {
            $query = "SELECT * FROM Preferiti
        WHERE id_film = ? AND id_utente = ?";
        } else {
            $query = "SELECT * FROM Preferiti
        WHERE id_serie = ? AND id_utente = ?";
        }

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "ii", $id_programma, $id_utente);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);

        return mysqli_num_rows($result) > 0;
    }
}
