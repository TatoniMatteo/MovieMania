<?php

class StatisticheController
{
    private $dbConnection;

    public function __construct(Database $db)
    {
        $this->dbConnection = $db;
    }

    public function getNumeroFilm()
    {
        $query = "SELECT COUNT(*) as numero
            FROM (SELECT id 
                FROM Film) as conto";

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

    public function getNumeroSerie()
    {
        $query = "SELECT COUNT(*) as numero
            FROM (SELECT id 
                FROM Serie) as conto";

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

    public function getNumeroPersonaggi()
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

    public function getAllFilm($offset, $limit)
    {
        $query = "SELECT Film.*, IFNULL(ROUND(AVG(Recensione.voto), 1), 0) AS media_voti, IFNULL(COUNT(Recensione.id), 0) AS numero_recensioni
            FROM Film
            LEFT JOIN Recensione ON Film.id = Recensione.id_film
            GROUP BY Film.id 
            ORDER BY Film.data_pubblicazione DESC, Film.titolo
            LIMIT ?, ?";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "ii", $offset, $limit);
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


    public function getAllSerie($offset, $limit)
    {
        $query = "SELECT Serie.*, IFNULL(ROUND(AVG(Recensione.voto), 1), 0) AS media_voti, IFNULL(COUNT(Recensione.id), 0) AS numero_recensioni, MIN(Stagione.data_pubblicazione) as data_pubblicazione
            FROM Serie
            LEFT JOIN Recensione ON Serie.id = Recensione.id_serie
            LEFT JOIN Stagione ON Serie.id = Stagione.id_serie
            GROUP BY Serie.id 
            ORDER BY data_pubblicazione DESC, Serie.titolo
            LIMIT ?, ?";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "ii", $offset, $limit);
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

    public function getAllPersonaggi($offset, $limit)
    {
        $query = "SELECT id, nome, cognome, nazionalita, data_nascita
            FROM Personaggi
            ORDER BY nome
            LIMIT ?, ?";

        $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
        mysqli_stmt_bind_param($statement, "ii", $offset, $limit);
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
