<?php

require_once '../../../../include/config.php';

class AuthController
{
    private $dbConnection;

    public function __construct(Database $db)
    {
        $this->dbConnection = $db;
    }


    public function loginControl($username, $password)
    {
        $query = "SELECT id
            FROM Utenti
            WHERE (Utenti.username = ? OR Utenti.email = ?) AND Utenti.password = ?";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "sss", $username, $username, $password);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);

        if (mysqli_num_rows($result) == 1) {
            $utente = mysqli_fetch_array($result);
            session_start();
            $_SESSION['utente'] = $utente['id'];
            return true;
        }

        return false;
    }

    public function registerUser($nome, $cognome, $username, $email, $password)
    {
        $query = "SELECT id FROM Utenti WHERE username = ? OR email = ?";
        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "ss", $username, $email);
        mysqli_stmt_execute($statement);
        $result = mysqli_stmt_get_result($statement);

        if (mysqli_num_rows($result) > 0) {
            return false;
        }

        $query = "INSERT INTO Utenti (nome, cognome, username, email, password) VALUES (?, ?, ?, ?, ?)";
        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "sssss", $nome, $cognome, $username, $email, $password);
        $result = mysqli_stmt_execute($statement);

        if ($result) {
            $newUserId = mysqli_insert_id($this->dbConnection->getConnection());
            session_start();
            $_SESSION['utente'] = $newUserId;
            return true;
        }

        return false;
    }
}
