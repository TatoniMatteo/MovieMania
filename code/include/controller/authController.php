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

        $query = "SELECT Utenti.id
        FROM Utenti
        WHERE (Utenti.username = '" . $username . "' OR Utenti.email = '" . $username . "') AND Utenti.password = '" . $password . "'";

        $result = mysqli_query($this->dbConnection->getConnection(), $query);

        if (mysqli_num_rows($result) == 1) {
            $utente = mysqli_fetch_array($result);
            session_start();
            $_SESSION['utente'] = $utente['id'];
            return True;
        }
        return False;
    }

    public function registerUser($nome, $cognome, $username, $email, $password)
    {
        // Verifica se l'username o l'email esistono già nel database
        $query = "SELECT id FROM Utenti WHERE username = '" . $username . "' OR email = '" . $email . "'";
        $result = mysqli_query($this->dbConnection->getConnection(), $query);

        if (mysqli_num_rows($result) > 0) {
            return false; // L'username o l'email esistono già, la registrazione fallisce
        }

        // Esegui l'inserimento del nuovo utente nel database
        $query = "INSERT INTO Utenti (nome, cognome, username, email, password) VALUES ('" . $nome . "', '" . $cognome . "', '" . $username . "', '" . $email . "', '" . $password . "')";
        $result = mysqli_query($this->dbConnection->getConnection(), $query);

        if ($result) {
            // Registrazione avvenuta con successo, ottieni l'ID del nuovo utente
            $newUserId = mysqli_insert_id($this->dbConnection->getConnection());

            // Salva l'ID dell'utente nella variabile di sessione 'utente'
            session_start();
            $_SESSION['utente'] = $newUserId;

            return true;
        }
        return false;
    }
}
