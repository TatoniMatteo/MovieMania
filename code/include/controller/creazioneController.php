<?php

class CreazioneController
{
    private $dbConnection;

    public function __construct(Database $db)
    {
        $this->dbConnection = $db;
    }

    function creaFilm($titolo, $descrizione, $copertina, $trailer, $durata, $data_p, $categorie, $produttori, $attori, $membri)
    {
        $connection = $this->dbConnection->getConnection();
        mysqli_autocommit($connection, false); // Disabilita l'autocommit

        try {
            $query = "INSERT INTO film (titolo, descrizione, copertina, trailer, durata, data_pubblicazione) 
            VALUES (?, ?, ?, ?, ?, ?)";

            $statement = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($statement, "ssssis", $titolo, $descrizione, $copertina, $trailer, $durata, $data_p);

            if (!$statement->execute()) {
                throw new Exception('Impossibile creare il film');
            }

            $filmId = mysqli_insert_id($connection);

            // Inserisci le categorie
            $query = "INSERT INTO caratterizza (id_film, id_categoria) VALUES (?, ?)";
            $statement = mysqli_prepare($connection, $query);

            foreach ($categorie as $categoria) {
                mysqli_stmt_bind_param($statement, "ii", $filmId, $categoria);
                if (!$statement->execute()) {
                    throw new Exception('Impossibile inserire una o più categorie');
                }
            }

            // Inserisci i produttori
            $query = "INSERT INTO partecipa (id_film, id_personaggio, ruolo, star) VALUES (?, ?, ?, ?)";
            $statement = mysqli_prepare($connection, $query);

            foreach ($produttori as $produttore) {
                $idPersonaggio = $produttore['personaggio'];
                $ruolo = $produttore['ruolo'];
                $star = $produttore['star'];

                mysqli_stmt_bind_param($statement, "iiii", $filmId, $idPersonaggio, $ruolo, $star);
                if (!$statement->execute()) {
                    throw new Exception('Impossibile inserire un produttore');
                }
            }

            // Inserisci gli attori
            $query = "INSERT INTO partecipa (id_film, id_personaggio, ruolo, interpreta, star) VALUES (?, ?, ?, ?, ?)";
            $statement = mysqli_prepare($connection, $query);
            foreach ($attori as $attore) {
                $idPersonaggio = $attore['personaggio'];
                $ruolo = 2;
                $interpreta = $attore['interpreta'];
                $star = $attore['star'];

                mysqli_stmt_bind_param($statement, "iiisi", $filmId, $idPersonaggio, $ruolo, $interpreta, $star);
                if (!$statement->execute()) {
                    throw new Exception('Impossibile inserire un attore');
                }
            }

            // Inserisci i membri
            $query = "INSERT INTO partecipa (id_film, id_personaggio, ruolo, star) VALUES (?, ?, ?, ?)";
            $statement = mysqli_prepare($connection, $query);
            foreach ($membri as $membro) {
                $idPersonaggio = $membro['personaggio'];
                $ruolo = $membro['ruolo'];
                $star = $membro['star'];

                mysqli_stmt_bind_param($statement, "iiii", $filmId, $idPersonaggio, $ruolo, $star);
                if (!$statement->execute()) {
                    throw new Exception('Impossibile inserire un membro');
                }
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

    function aggiornaFilm($idFilm, $titolo, $descrizione, $copertina, $trailer, $durata, $data_p, $categorie, $produttori, $attori, $membri)
    {
        $connection = $this->dbConnection->getConnection();
        mysqli_autocommit($connection, false); // Disabilita l'autocommit

        try {
            // Aggiorna i parametri del film
            $query = "UPDATE film SET titolo = ?, descrizione = ?, copertina = ?, trailer = ?, durata = ?, data_pubblicazione = ? WHERE id = ?";
            $statement = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($statement, "ssssisi", $titolo, $descrizione, $copertina, $trailer, $durata, $data_p, $idFilm);
            if (!$statement->execute()) {
                throw new Exception('Impossibile aggiornare i parametri del film');
            }

            // Aggiorna le categorie del film

            $query = "DELETE FROM caratterizza WHERE id_film = ?";
            $statement = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($statement, "i", $idFilm);
            mysqli_stmt_execute($statement);

            $query = "INSERT INTO caratterizza (id_film, id_categoria) VALUES (?, ?)";
            $statement = mysqli_prepare($connection, $query);

            foreach ($categorie as $categoria) {
                mysqli_stmt_bind_param($statement, "ii", $idFilm, $categoria);
                if (!$statement->execute()) {
                    throw new Exception('Impossibile inserire una o più categorie');
                }
            }

            // Aggiorna i produttori del film
            $query = "DELETE FROM partecipa WHERE id_film = ?";
            $statement = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($statement, "i", $idFilm);
            mysqli_stmt_execute($statement);

            // Inserisci i produttori
            $query = "INSERT INTO partecipa (id_film, id_personaggio, ruolo, star) VALUES (?, ?, ?, ?)";
            $statement = mysqli_prepare($connection, $query);

            foreach ($produttori as $produttore) {
                $idPersonaggio = $produttore['personaggio'];
                $ruolo = $produttore['ruolo'];
                $star = $produttore['star'];

                mysqli_stmt_bind_param($statement, "iiii", $idFilm, $idPersonaggio, $ruolo, $star);
                if (!$statement->execute()) {
                    throw new Exception('Impossibile inserire un produttore');
                }
            }

            // Inserisci gli attori
            $query = "INSERT INTO partecipa (id_film, id_personaggio, ruolo, interpreta, star) VALUES (?, ?, ?, ?, ?)";
            $statement = mysqli_prepare($connection, $query);
            foreach ($attori as $attore) {
                $idPersonaggio = $attore['personaggio'];
                $ruolo = 2;
                $interpreta = $attore['interpreta'];
                $star = $attore['star'];

                mysqli_stmt_bind_param($statement, "iiisi", $idFilm, $idPersonaggio, $ruolo, $interpreta, $star);
                if (!$statement->execute()) {
                    throw new Exception('Impossibile inserire un attore');
                }
            }

            // Inserisci i membri
            $query = "INSERT INTO partecipa (id_film, id_personaggio, ruolo, star) VALUES (?, ?, ?, ?)";
            $statement = mysqli_prepare($connection, $query);
            foreach ($membri as $membro) {
                $idPersonaggio = $membro['personaggio'];
                $ruolo = $membro['ruolo'];
                $star = $membro['star'];

                mysqli_stmt_bind_param($statement, "iiii", $idFilm, $idPersonaggio, $ruolo, $star);
                if (!$statement->execute()) {
                    throw new Exception('Impossibile inserire un membro');
                }
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

    function aggiornaPersonaggio($personaggioId, $nome, $cognome, $foto, $biografia, $nascita, $nazionalita, $sesso, $morte)
    {
        try {
            $query = "UPDATE personaggi SET nome = ?, cognome = ?, foto = ?, biografia = ?, 
            data_nascita = ?, nazionalita = ?, sesso = ?, data_morte = ? WHERE id = ?";
            $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
            mysqli_stmt_bind_param($statement, "ssssssisi", $nome, $cognome, $foto, $biografia, $nascita, $nazionalita, $sesso, $morte, $personaggioId);
            if (!$statement->execute()) {
                throw new Exception('Impossibile aggiornare i parametri della celebrita');
            }
            return array('success' => true);
        } catch (Exception $e) {
            return array('success' => false, 'message' => $e->getMessage());
        }
    }

    function creaPersonaggio($nome, $cognome, $foto, $biografia, $nascita, $nazionalita, $sesso, $morte)
    {
        try {
            $query = 'INSERT INTO personaggi (nome, cognome, foto, biografia, data_nascita, nazionalita, sesso, data_morte)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)';

            $statement = mysqli_prepare($this->dbConnection->getConnection(), $query);
            mysqli_stmt_bind_param($statement, "ssssssis", $nome, $cognome, $foto, $biografia, $nascita, $nazionalita, $sesso, $morte);
            if (!$statement->execute()) {
                throw new Exception('Impossibile creare la celebrita');
            }
            return array('success' => true);
        } catch (Exception $e) {
            return array('success' => false, 'message' => $e->getMessage());
        }
    }

    function creaSerie($titolo, $descrizione, $copertina, $trailer, $conclusa, $categorie, $produttori, $attori, $membri, $stagioni)
    {
        $connection = $this->dbConnection->getConnection();
        mysqli_autocommit($connection, false); // Disabilita l'autocommit

        try {
            $query = "INSERT INTO serie (titolo, descrizione, copertina, trailer, conclusa) 
            VALUES (?, ?, ?, ?, ?)";

            $statement = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($statement, "ssssi", $titolo, $descrizione, $copertina, $trailer, $conclusa);

            if (!$statement->execute()) {
                throw new Exception('Impossibile creare il film');
            }

            $serieId = mysqli_insert_id($connection);

            // Inserisci le categorie
            $query = "INSERT INTO caratterizza (id_serie, id_categoria) VALUES (?, ?)";
            $statement = mysqli_prepare($connection, $query);

            foreach ($categorie as $categoria) {
                mysqli_stmt_bind_param($statement, "ii", $serieId, $categoria);
                if (!$statement->execute()) {
                    throw new Exception('Impossibile inserire una o più categorie');
                }
            }

            // Inserisci i produttori
            $query = "INSERT INTO partecipa (id_serie, id_personaggio, ruolo, star) VALUES (?, ?, ?, ?)";
            $statement = mysqli_prepare($connection, $query);

            foreach ($produttori as $produttore) {
                $idPersonaggio = $produttore['personaggio'];
                $ruolo = $produttore['ruolo'];
                $star = $produttore['star'];

                mysqli_stmt_bind_param($statement, "iiii", $serieId, $idPersonaggio, $ruolo, $star);
                if (!$statement->execute()) {
                    throw new Exception('Impossibile inserire un produttore');
                }
            }

            // Inserisci gli attori
            $query = "INSERT INTO partecipa (id_serie, id_personaggio, ruolo, interpreta, star) VALUES (?, ?, ?, ?, ?)";
            $statement = mysqli_prepare($connection, $query);
            foreach ($attori as $attore) {
                $idPersonaggio = $attore['personaggio'];
                $ruolo = 2;
                $interpreta = $attore['interpreta'];
                $star = $attore['star'];

                mysqli_stmt_bind_param($statement, "iiisi", $serieId, $idPersonaggio, $ruolo, $interpreta, $star);
                if (!$statement->execute()) {
                    throw new Exception('Impossibile inserire un attore');
                }
            }

            // Inserisci i membri
            $query = "INSERT INTO partecipa (id_serie, id_personaggio, ruolo, star) VALUES (?, ?, ?, ?)";
            $statement = mysqli_prepare($connection, $query);
            foreach ($membri as $membro) {
                $idPersonaggio = $membro['personaggio'];
                $ruolo = $membro['ruolo'];
                $star = $membro['star'];

                mysqli_stmt_bind_param($statement, "iiii", $serieId, $idPersonaggio, $ruolo, $star);
                if (!$statement->execute()) {
                    throw new Exception('Impossibile inserire un membro');
                }
            }

            // Inserisci stagioni
            $query = "INSERT INTO Stagione (id_serie, numero_stagione, episodi, data_pubblicazione, copertina) VALUES (?, ?, ?, ?, ?)";
            $statement = mysqli_prepare($connection, $query);
            foreach ($stagioni as $stagione) {
                $numero = $stagione['numero_stagione'];
                $episodi = $stagione['episodi'];
                $data = $stagione['data_pubblicazione'];
                $copertina = $stagione['copertina'];

                mysqli_stmt_bind_param($statement, "iiiss", $serieId, $numero, $episodi, $data, $copertina);
                if (!$statement->execute()) {
                    throw new Exception('Impossibile inserire una stagione');
                }
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

    function aggiornaSerie($serieId, $titolo, $descrizione, $copertina, $trailer, $conclusa, $categorie, $produttori, $attori, $membri, $stagioni)
    {
        $connection = $this->dbConnection->getConnection();
        mysqli_autocommit($connection, false); // Disabilita l'autocommit

        try {
            // Aggiorna i parametri del film
            $query = "UPDATE serie SET titolo = ?, descrizione = ?, copertina = ?, trailer = ?, conclusa = ? WHERE id = ?";
            $statement = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($statement, "ssssii", $titolo, $descrizione, $copertina, $trailer, $conclusa, $serieId);
            if (!$statement->execute()) {
                throw new Exception('Impossibile aggiornare i parametri del film');
            }

            // Aggiorna le categorie del film

            $query = "DELETE FROM caratterizza WHERE id_serie = ?";
            $statement = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($statement, "i", $serieId);
            mysqli_stmt_execute($statement);

            $query = "INSERT INTO caratterizza (id_serie, id_categoria) VALUES (?, ?)";
            $statement = mysqli_prepare($connection, $query);

            foreach ($categorie as $categoria) {
                mysqli_stmt_bind_param($statement, "ii", $serieId, $categoria);
                if (!$statement->execute()) {
                    throw new Exception('Impossibile inserire una o più categorie');
                }
            }

            // Aggiorna i produttori del film
            $query = "DELETE FROM partecipa WHERE id_serie = ?";
            $statement = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($statement, "i", $serieId);
            mysqli_stmt_execute($statement);

            // Inserisci i produttori
            $query = "INSERT INTO partecipa (id_serie, id_personaggio, ruolo, star) VALUES (?, ?, ?, ?)";
            $statement = mysqli_prepare($connection, $query);

            foreach ($produttori as $produttore) {
                $idPersonaggio = $produttore['personaggio'];
                $ruolo = $produttore['ruolo'];
                $star = $produttore['star'];

                mysqli_stmt_bind_param($statement, "iiii", $serieId, $idPersonaggio, $ruolo, $star);
                if (!$statement->execute()) {
                    throw new Exception('Impossibile inserire un produttore');
                }
            }

            // Inserisci gli attori
            $query = "INSERT INTO partecipa (id_serie, id_personaggio, ruolo, interpreta, star) VALUES (?, ?, ?, ?, ?)";
            $statement = mysqli_prepare($connection, $query);
            foreach ($attori as $attore) {
                $idPersonaggio = $attore['personaggio'];
                $ruolo = 2;
                $interpreta = $attore['interpreta'];
                $star = $attore['star'];

                mysqli_stmt_bind_param($statement, "iiisi", $serieId, $idPersonaggio, $ruolo, $interpreta, $star);
                if (!$statement->execute()) {
                    throw new Exception('Impossibile inserire un attore');
                }
            }

            // Inserisci i membri
            $query = "INSERT INTO partecipa (id_serie, id_personaggio, ruolo, star) VALUES (?, ?, ?, ?)";
            $statement = mysqli_prepare($connection, $query);
            foreach ($membri as $membro) {
                $idPersonaggio = $membro['personaggio'];
                $ruolo = $membro['ruolo'];
                $star = $membro['star'];

                mysqli_stmt_bind_param($statement, "iiii", $serieId, $idPersonaggio, $ruolo, $star);
                if (!$statement->execute()) {
                    throw new Exception('Impossibile inserire un membro');
                }
            }

            // Rimuovi stagioni
            $query = "DELETE FROM Stagione WHERE id_serie = ?";
            $statement = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($statement, "i", $serieId);
            mysqli_stmt_execute($statement);

            // Inserisci stagioni
            $query = "INSERT INTO Stagione (id_serie, numero_stagione, episodi, data_pubblicazione, copertina) VALUES (?, ?, ?, ?, ?)";
            $statement = mysqli_prepare($connection, $query);
            foreach ($stagioni as $stagione) {
                $numero = $stagione['numero_stagione'];
                $episodi = $stagione['episodi'];
                $data = $stagione['data_pubblicazione'];
                $copertina = $stagione['copertina'];

                mysqli_stmt_bind_param($statement, "iiiss", $serieId, $numero, $episodi, $data, $copertina);
                if (!$statement->execute()) {
                    throw new Exception('Impossibile inserire una stagione');
                }
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
