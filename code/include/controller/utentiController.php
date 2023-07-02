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
        WHERE Utenti.id =" . $id;

        $result = mysqli_query($this->dbConnection->getConnection(), $query);

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
        WHERE P.id_utente = " . $id . " 
        GROUP BY F.id";


        $result = mysqli_query($this->dbConnection->getConnection(), $query);
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
        WHERE P.id_utente = " . $id . "
        GROUP BY S.id";


        $result = mysqli_query($this->dbConnection->getConnection(), $query);
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
        if ($username != "") $modifiche[] = 'username = \'' . $username . '\'';
        if ($email != "") $modifiche[] = 'email = \'' . $email . '\'';
        if ($nome != "") $modifiche[] = 'nome = \'' . $nome . '\'';
        if ($cognome != "") $modifiche[] = 'cognome = \'' . $cognome . '\'';

        $query = "UPDATE utenti
            SET " . implode(', ', $modifiche) . "
            WHERE id = " . $id;

        if (mysqli_query($this->dbConnection->getConnection(), $query)) {
            return true;
        }
        return false;
    }

    public function updatePassword($id, $old, $new)
    {
        $query = "SELECT Utenti.password 
        FROM Utenti
        WHERE Utenti.id =" . $id;

        $result = mysqli_query($this->dbConnection->getConnection(), $query);

        if (mysqli_num_rows($result) > 0) {
            $check =  mysqli_fetch_assoc($result)['password'];
        } else {
            return false;
        }

        if ($old == $check) {
            $query = "UPDATE utenti
            SET password = '" . $new . "'
            WHERE id = " . $id;

            if (mysqli_query($this->dbConnection->getConnection(), $query)) {
                return true;
            }
        }
        return false;
    }
}
