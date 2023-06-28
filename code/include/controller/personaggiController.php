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
        WHERE Personaggi.id =" . $id;

        $result = mysqli_query($this->dbConnection->getConnection(), $query);

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
        WHERE Partecipa.id_film =" . $id;

        $result = mysqli_query($this->dbConnection->getConnection(), $query);
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
        WHERE Partecipa.id_serie =" . $id;

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
