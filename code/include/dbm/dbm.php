<?php
class Database
{
    private $conn;

    public function __construct()
    {
        $host = "localhost";
        $username = "root";
        $password = "";
        $database = "moviemania";
        $this->conn = mysqli_connect($host, $username, $password, $database);

        if (!$this->conn) {
            die("Connessione al database fallita: " . mysqli_connect_error());
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
