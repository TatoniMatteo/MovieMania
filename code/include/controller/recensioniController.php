<?php

class RecensioniController
{
    private $dbConnection;

    public function __construct(Database $db)
    {
        $this->dbConnection = $db;
    }

    public function getRecensioniByFilm($id)
    {
        $query = "SELECT Recensione.*, Utenti.foto as foto_utente, Utenti.nome as nome_utente, Utenti.cognome as cognome_utente
        FROM Recensione
        INNER JOIN Utenti ON Recensione.id_utente = Utenti.id
        WHERE Recensione.id_film =" . $id . "
        ORDER BY Recensione.voto DESC";

        $result = mysqli_query($this->dbConnection->getConnection(), $query);
        $recensioni = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $recensioni[] = $row;
            }
        }
        return $recensioni;
    }

    public function getRecesioniBySerie($id)
    {
        $query = "SELECT Recensione.*, Utenti.foto, Utenti.nome, Utenti.cognome
        FROM Recensione
        INNER JOIN Utenti ON Recensione.id_utente = Utenti.id
        WHERE Recensione.id_serie =" . $id . "
        ORDER BY Recensione.voto DESC";

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
        $query = "SELECT COUNT(Film.*) AS numero_recensioni 
        FROM Film;
        WHERE Recensione.id_film =" . $id;

        $result = mysqli_query($this->dbConnection->getConnection(), $query);

        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_array($result);
        } else {
            return null;
        }
    }

    public function getNumeroRecesioniBySerie($id)
    {
        $query = "SELECT COUNT(Serie.*) AS numero_recensioni 
        FROM Serie;
        WHERE Recensione.id_serie =" . $id;

        $result = mysqli_query($this->dbConnection->getConnection(), $query);

        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_array($result);
        } else {
            return null;
        }
    }
}
