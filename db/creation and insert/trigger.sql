-- Trigger per impedire recensioni duplicate per lo stesso utente e lo stesso film/serie,
-- e per controllare la coerenza di id_film e id_serie in Recensione
DELIMITER //

CREATE TRIGGER trg_check_recensione_duplicate_and_film_serie
    BEFORE INSERT
    ON Recensione
    FOR EACH ROW
BEGIN
    IF EXISTS (SELECT 1
               FROM Recensione
               WHERE id_utente = NEW.id_utente
                 AND ((id_film IS NOT NULL AND id_film = NEW.id_film) OR
                      (id_serie IS NOT NULL AND id_serie = NEW.id_serie))) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Film o serie già recensita';
    ELSEIF (NEW.id_film IS NOT NULL AND NEW.id_serie IS NOT NULL) OR (NEW.id_film IS NULL AND NEW.id_serie IS NULL) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Valori non validi per id_film e id_serie';
    END IF;
END//

DELIMITER ;

-- Trigger per controllare la coerenza di id_film e id_serie in Preferiti
DELIMITER //

CREATE TRIGGER trg_check_preferiti_film_serie_null
    BEFORE INSERT
    ON Preferiti
    FOR EACH ROW
BEGIN
    IF (NEW.id_film IS NOT NULL AND NEW.id_serie IS NOT NULL) OR (NEW.id_film IS NULL AND NEW.id_serie IS NULL) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Valori non validi per id_film e id_serie';
    END IF;
END//

DELIMITER ;


-- Trigger per controllare la coerenza di id_film e id_serie in Partecipa
DELIMITER //

CREATE TRIGGER trg_check_partecipa_film_serie_null
    BEFORE INSERT
    ON Partecipa
    FOR EACH ROW
BEGIN
    IF (NEW.id_film IS NOT NULL AND NEW.id_serie IS NOT NULL) OR (NEW.id_film IS NULL AND NEW.id_serie IS NULL) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Valori non validi per id_film e id_serie';
    END IF;
END//

DELIMITER ;


-- Trigger per controllare la coerenza di id_film e id_serie in Caratterizza
DELIMITER //

CREATE TRIGGER trg_check_caratterizza_film_serie_null
    BEFORE INSERT
    ON Caratterizza
    FOR EACH ROW
BEGIN
    IF (NEW.id_film IS NOT NULL AND NEW.id_serie IS NOT NULL) OR (NEW.id_film IS NULL AND NEW.id_serie IS NULL) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Valori non validi per id_film e id_serie';
    END IF;
END//

DELIMITER ;
