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
}
