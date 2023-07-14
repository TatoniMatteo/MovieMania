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
        $connection = $this->dbConnection->getConnection();
        mysqli_autocommit($connection, false); // Disabilita l'autocommit

        try {
            $query = "SELECT id FROM Utenti WHERE username = ? OR email = ?";
            $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
            mysqli_stmt_bind_param($statement, "ss", $username, $email);
            mysqli_stmt_execute($statement);
            $result = mysqli_stmt_get_result($statement);

            if (mysqli_num_rows($result) > 0) {
                throw new Exception('Email e/o username già in uso!');
            }

            $query = "INSERT INTO Utenti (nome, cognome, username, email, password) VALUES (?, ?, ?, ?, ?)";
            $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
            mysqli_stmt_bind_param($statement, "sssss", $nome, $cognome, $username, $email, $password);
            $result = mysqli_stmt_execute($statement);

            $newUserId = null;
            if ($result) {
                $newUserId = mysqli_insert_id($this->dbConnection->getConnection());
                session_start();
                $_SESSION['utente'] = $newUserId;
            } else {
                throw new Exception('Impossibile creare l\'utente');
            }

            if ($newUserId) {
                $query = "INSERT INTO Possiede (utente_id, permesso_id) VALUES (? , 1)";
                $statement = mysqli_prepare($connection, $query);
                mysqli_stmt_bind_param($statement, "i", $newUserId);
                mysqli_stmt_execute($statement);
            } else {
                throw new Exception('Impossibile creare l\'utente');
            }

            mysqli_commit($connection); // Commit della transazione
            mysqli_autocommit($connection, true); // Riabilita l'autocommit
            return array('success' => true);
        } catch (Exception $e) {
            mysqli_rollback($connection); // Rollback della transazione
            mysqli_autocommit($connection, true); // Riabilita l'autocommit
            return array('success' => false, 'message' => $e->getMessage());
        }
    }
}
