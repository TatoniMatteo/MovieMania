<?php

class StatisticheController
{
    private $dbConnection;

    public function __construct(Database $db)
    {
        $this->dbConnection = $db;
    }

    public function getNumeroFilm($filtro)
    {
        $query = "SELECT COUNT(*) as numero
            FROM (
                SELECT id 
                FROM Film
                WHERE Film.titolo LIKE CONCAT('%', ?, '%') OR SOUNDEX(Film.titolo) = SOUNDEX(?)
                ) as conto";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "ss", $filtro, $filtro);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row['numero'];
        } else {
            return null;
        }
    }

    public function getNumeroSerie($filtro)
    {
        $query = "SELECT COUNT(*) as numero
            FROM (
                    SELECT id 
                    FROM Serie
                    WHERE Serie.titolo LIKE CONCAT('%', ?, '%') OR SOUNDEX(Serie.titolo) = SOUNDEX(?)
                ) as conto";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "ss", $filtro, $filtro);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row['numero'];
        } else {
            return null;
        }
    }

    public function getNumeroPersonaggi($filtro)
    {
        $query = "SELECT COUNT(*) as numero
            FROM (
                    SELECT id, nome, cognome, nazionalita, data_nascita
                    FROM Personaggi
                    WHERE (Personaggi.nome LIKE CONCAT('%', ?, '%') OR Personaggi.cognome LIKE CONCAT('%', ?, '%')
                        OR CONCAT(Personaggi.nome, ' ', Personaggi.cognome) LIKE CONCAT('%', ?, '%')
                        OR SOUNDEX(Personaggi.nome) = SOUNDEX(?)
                        OR SOUNDEX(Personaggi.cognome) = SOUNDEX(?)
                        OR SOUNDEX(CONCAT(Personaggi.nome, ' ', Personaggi.cognome)) =  SOUNDEX(?))
                ) as conto";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "ssssss", $filtro, $filtro, $filtro, $filtro, $filtro, $filtro);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row['numero'];
        } else {
            return null;
        }
    }

    public function getNumeroCelebrità()
    {
        $query = "SELECT COUNT(*) as numero
            FROM (SELECT id 
                FROM Personaggi) as conto";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row['numero'];
        } else {
            return null;
        }
    }

    public function getNumeroRecensioni()
    {
        $query = "SELECT COUNT(*) as numero
            FROM (SELECT id 
                FROM Recensione) as conto";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row['numero'];
        } else {
            return null;
        }
    }

    public function getNumeroUtenti($filtro)
    {
        $query = "SELECT COUNT(*) as numero
            FROM (
                    SELECT Utenti.id 
                    FROM Utenti
                    WHERE Utenti.nome LIKE CONCAT('%', ?, '%') OR Utenti.cognome LIKE CONCAT('%', ?, '%')
                        OR CONCAT(Utenti.nome, ' ', Utenti.cognome) LIKE CONCAT('%', ?, '%')
                        OR Utenti.username LIKE CONCAT('%', ?, '%') OR Utenti.email LIKE CONCAT('%', ?, '%')
                        OR SOUNDEX(Utenti.nome) = SOUNDEX(?)
                        OR SOUNDEX(Utenti.cognome) = SOUNDEX(?)
                        OR SOUNDEX(CONCAT(Utenti.nome, ' ', Utenti.cognome)) =  SOUNDEX(?)
                        OR SOUNDEX(Utenti.username) = SOUNDEX(?)
                        OR SOUNDEX(Utenti.email) = SOUNDEX(?)
                ) as conto";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "ssssssssss", $filtro, $filtro, $filtro, $filtro, $filtro, $filtro, $filtro, $filtro, $filtro, $filtro,);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row['numero'];
        }
        return null;
    }


    public function getAllFilm($offset, $limit, $filtro)
    {
        $query = "SELECT Film.*, IFNULL(ROUND(AVG(Recensione.voto), 1), 0) AS media_voti, IFNULL(COUNT(Recensione.id), 0) AS numero_recensioni
            FROM Film
            LEFT JOIN Recensione ON Film.id = Recensione.id_film
            WHERE Film.titolo LIKE CONCAT('%', ?, '%') OR SOUNDEX(Film.titolo) = SOUNDEX(?)
            GROUP BY Film.id 
            ORDER BY Film.data_pubblicazione DESC, Film.titolo
            LIMIT ?, ?";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "ssii", $filtro, $filtro, $offset, $limit);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);
        $films = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $films[] = $row;
            }
        }

        return $films;
    }


    public function getAllSerie($offset, $limit, $filtro)
    {

        $query = "SELECT Serie.*, IFNULL(ROUND(AVG(Recensione.voto), 1), 0) AS media_voti, IFNULL(COUNT(Recensione.id), 0) AS numero_recensioni, MIN(Stagione.data_pubblicazione) as data_pubblicazione
            FROM Serie
            LEFT JOIN Recensione ON Serie.id = Recensione.id_serie
            LEFT JOIN Stagione ON Serie.id = Stagione.id_serie
            LEFT JOIN Caratterizza CS ON Serie.id = CS.id_serie
            WHERE Serie.titolo LIKE CONCAT('%', ?, '%') OR SOUNDEX(Serie.titolo) = SOUNDEX(?)
            GROUP BY Serie.id 
            ORDER BY data_pubblicazione DESC, Serie.titolo
            LIMIT ?, ?";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "ssii", $filtro, $filtro, $offset, $limit);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);
        $serie = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $serie[] = $row;
            }
        }

        return $serie;
    }

    public function getAllPersonaggi($offset, $limit, $filtro)
    {
        $query = "SELECT id, nome, cognome, nazionalita, data_nascita
        FROM Personaggi
        WHERE (Personaggi.nome LIKE CONCAT('%', ?, '%') OR Personaggi.cognome LIKE CONCAT('%', ?, '%')
            OR CONCAT(Personaggi.nome, ' ', Personaggi.cognome) LIKE CONCAT('%', ?, '%')
            OR SOUNDEX(Personaggi.nome) = SOUNDEX(?)
            OR SOUNDEX(Personaggi.cognome) = SOUNDEX(?)
            OR SOUNDEX(CONCAT(Personaggi.nome, ' ', Personaggi.cognome)) =  SOUNDEX(?))
            ORDER BY nome
            LIMIT ?, ?";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "ssssssii", $filtro, $filtro, $filtro, $filtro, $filtro, $filtro, $offset, $limit);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);
        $personaggi = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $personaggi[] = $row;
            }
        }

        return $personaggi;
    }


    public function getAllUtenti($offset, $limit, $filtro)
    {
        try {

            $query = "SELECT Utenti.id, Utenti.nome, Utenti.cognome, Utenti.email, Utenti.username, Permessi.id AS id_permesso
                        FROM Utenti
                        INNER JOIN Possiede ON Utenti.id = Possiede.utente_id
                        INNER JOIN Permessi ON Possiede.permesso_id = Permessi.id
                        WHERE Utenti.nome LIKE CONCAT('%', ?, '%') OR Utenti.cognome LIKE CONCAT('%', ?, '%')
                            OR CONCAT(Utenti.nome, ' ', Utenti.cognome) LIKE CONCAT('%', ?, '%')
                            OR Utenti.username LIKE CONCAT('%', ?, '%') OR Utenti.email LIKE CONCAT('%', ?, '%')
                            OR SOUNDEX(Utenti.nome) = SOUNDEX(?)
                            OR SOUNDEX(Utenti.cognome) = SOUNDEX(?)
                            OR SOUNDEX(CONCAT(Utenti.nome, ' ', Utenti.cognome)) =  SOUNDEX(?)
                            OR SOUNDEX(Utenti.username) = SOUNDEX(?)
                            OR SOUNDEX(Utenti.email) = SOUNDEX(?)
                            ORDER BY Utenti.nome, Utenti.cognome
                            LIMIT ?, ?";

            $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
            if (!$statement) {
                throw new Exception("Errore nella preparazione della query.");
            }

            mysqli_stmt_bind_param($statement, "ssssssssssii", $filtro, $filtro, $filtro, $filtro, $filtro, $filtro, $filtro, $filtro, $filtro, $filtro, $offset, $limit);
            if (!mysqli_stmt_execute($statement)) {
                throw new Exception("Errore nell'esecuzione della query.");
            }

            $result = mysqli_stmt_get_result($statement);
            if (!$result) {
                throw new Exception("Errore nell'ottenimento del risultato dalla query.");
            }

            $utenti = array();

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $utenteId = $row['id'];

                    if (!isset($utenti[$utenteId])) {
                        $utenti[$utenteId] = array(
                            'id' => $row['id'],
                            'nome' => $row['nome'],
                            'cognome' => $row['cognome'],
                            'email' => $row['email'],
                            'username' => $row['username'],
                            'permessi' => array()
                        );
                    }

                    $utenti[$utenteId]['permessi'][] = $row['id_permesso'];
                }
            }

            return array(
                'success' => true,
                'data' => $utenti
            );
        } catch (Exception $e) {
            return array(
                'success' => false,
                'message' => $e->getMessage()
            );
        }
    }





    public function getPersonaggi()
    {
        $query = "SELECT id, nome, cognome, nazionalita, data_nascita
            FROM Personaggi
            ORDER BY nome";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);
        $personaggi = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $personaggi[] = $row;
            }
        }

        return $personaggi;
    }

    public function getAllCategorie()
    {
        $query = "SELECT * 
        FROM categoria
        ORDER BY categoria";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);
        $personaggi = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $personaggi[] = $row;
            }
        }

        return $personaggi;
    }

    public function getMounthReview()
    {
        $query = "SELECT DATE(data_recensione) AS giorno, COUNT(*) AS numero_recensioni
        FROM recensione
        WHERE data_recensione >= CURDATE() - INTERVAL 29 DAY
        GROUP BY giorno
        ORDER BY giorno ASC;";

        $result = mysqli_query($this->dbConnection->getConnection(), $query);

        $recensioni = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $recensioni[$row['giorno']] = $row['numero_recensioni'];
        }

        $oggi = date('Y-m-d');
        for ($i = 0; $i < 30; $i++) {
            $giorno = date('Y-m-d', strtotime($oggi . " -$i days"));
            if (!isset($recensioni[$giorno])) {
                $recensioni[$giorno] = 0;
            }
        }

        ksort($recensioni);
        return $recensioni;
    }

    public function getYearReview()
    {
        $query = "SELECT YEAR(data_recensione) AS anno, MONTH(data_recensione) AS mese, COUNT(*) AS numero_recensioni
        FROM recensione
        WHERE data_recensione >= CURDATE() - INTERVAL 12 MONTH
        GROUP BY YEAR(data_recensione), MONTH(data_recensione)
        ORDER BY anno ASC, mese ASC;";

        $result = mysqli_query($this->dbConnection->getConnection(), $query);
        $recensioniPerMese = array();

        $formatter = new IntlDateFormatter('it_IT', IntlDateFormatter::NONE, IntlDateFormatter::NONE, null, null, 'MMM');

        while ($row = mysqli_fetch_assoc($result)) {
            $anno = $row['anno'];
            $mese = $row['mese'];
            $numeroRecensioni = $row['numero_recensioni'];

            $nomeMese = $formatter->format(mktime(0, 0, 0, $mese, 1, $anno));
            $chiave = "$anno-$mese";

            $recensioniPerMese[$chiave] = array(
                'mese' => $nomeMese,
                'anno' => $anno,
                'numero_recensioni' => $numeroRecensioni
            );
        }

        for ($i = 0; $i <= 12; $i++) {
            $anno = date('Y', strtotime("-$i months"));
            $mese = date('n', strtotime("-$i months"));
            $chiave = "$anno-$mese";

            if (!isset($recensioniPerMese[$chiave])) {
                $nomeMese = $formatter->format(mktime(0, 0, 0, $mese, 1, $anno));

                $recensioniPerMese[$chiave] = array(
                    'mese' => $nomeMese,
                    'anno' => $anno,
                    'numero_recensioni' => 0
                );
            }
        }

        return $recensioniPerMese;
    }

    function getPersonaggiByFilm($id)
    {
        $query = "SELECT Personaggi.nome, Personaggi.cognome, Personaggi.id, Partecipa.ruolo, Partecipa.star, Partecipa.interpreta, Ruolo.categoria as categoria_ruolo
        FROM Partecipa
        INNER JOIN Personaggi ON Partecipa.id_personaggio = Personaggi.id
        INNER JOIN Ruolo ON Partecipa.ruolo = Ruolo.id
        WHERE Partecipa.id_film = ?";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "i", $id);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);
        $personaggi = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $personaggi[] = $row;
            }
        }

        return $personaggi;
    }

    function getPersonaggiBySerie($id)
    {
        $query = "SELECT Personaggi.nome, Personaggi.cognome, Personaggi.id, Partecipa.ruolo, Partecipa.star, Partecipa.interpreta, Ruolo.categoria as categoria_ruolo
        FROM Partecipa
        INNER JOIN Personaggi ON Partecipa.id_personaggio = Personaggi.id
        INNER JOIN Ruolo ON Partecipa.ruolo = Ruolo.id
        WHERE Partecipa.id_serie = ?";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "i", $id);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);
        $personaggi = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $personaggi[] = $row;
            }
        }

        return $personaggi;
    }

    function getCategorieByFilm($id)
    {
        $query = "SELECT id_categoria
        FROM Caratterizza
        WHERE Caratterizza.id_film = ?";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "i", $id);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);
        $categorie = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $categorie[] = $row;
            }
        }

        return $categorie;
    }

    function getCategorieBySerie($id)
    {
        $query = "SELECT id_categoria
        FROM Caratterizza
        WHERE Caratterizza.id_serie = ?";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "i", $id);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);
        $categorie = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $categorie[] = $row;
            }
        }

        return $categorie;
    }

    function getStagioniBySerie($id)
    {
        $query = "SELECT *
        FROM Stagione
        WHERE id_serie = ?";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "i", $id);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);
        $stagioni = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $stagioni[] = $row;
            }
        }

        return $stagioni;
    }


    function getRuoli()
    {
        $query = "SELECT *
        FROM Ruolo";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);
        $ruoli = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $ruoli[] = $row;
            }
        }

        return $ruoli;
    }
}
