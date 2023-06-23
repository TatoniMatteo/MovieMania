-- Rimuovi lo schema esistente (se presente)
DROP SCHEMA IF EXISTS moviemania;
CREATE SCHEMA moviemania;
USE moviemania;

-- Tabella: Film
CREATE TABLE Film
(
    id                 INT PRIMARY KEY AUTO_INCREMENT,
    titolo             VARCHAR(255) NOT NULL,
    data_pubblicazione DATE         NOT NULL,
    descrizione        TEXT         NOT NULL,
    trailer            VARCHAR(255),
    durata             INT          NOT NULL,
    copertina          BLOB         NOT NULL,
    CONSTRAINT chk_durata_positive CHECK (durata > 0),
    CONSTRAINT unique_titolo_data_pubblicazione UNIQUE (titolo, data_pubblicazione)
);

-- Tabella: Serie
CREATE TABLE Serie
(
    id          INT PRIMARY KEY AUTO_INCREMENT,
    titolo      VARCHAR(255) NOT NULL,
    descrizione TEXT         NOT NULL,
    trailer     VARCHAR(255),
    copertina   BLOB         NOT NULL,
    conclusa    BOOLEAN      NOT NULL
);

-- Tabella: Utenti
CREATE TABLE Utenti
(
    id       INT PRIMARY KEY AUTO_INCREMENT,
    nome     VARCHAR(255) NOT NULL,
    cognome  VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    email    VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    foto     BLOB,
    CONSTRAINT unique_username UNIQUE (username),
    CONSTRAINT unique_email UNIQUE (email)
);

-- Tabella: Stagione
CREATE TABLE Stagione
(
    id                 INT PRIMARY KEY AUTO_INCREMENT,
    data_pubblicazione DATE NOT NULL,
    copertina          BLOB NOT NULL,
    id_serie           INT  NOT NULL,
    numero_stagione    INT  NOT NULL,
    CONSTRAINT fk_appartiene_stagione FOREIGN KEY (id_serie) REFERENCES Stagione (id) ON DELETE RESTRICT ON UPDATE CASCADE

);

-- Tabella: Personaggi
CREATE TABLE Personaggi
(
    id           INT PRIMARY KEY AUTO_INCREMENT,
    nome         VARCHAR(255) NOT NULL,
    cognome      VARCHAR(255) NOT NULL,
    data_nascita DATE         NOT NULL,
    nazionalita  VARCHAR(255) NOT NULL,
    altezza      DECIMAL(3, 2),
    biografia    TEXT         NOT NULL
);

-- Tabella: Ruolo
CREATE TABLE Ruolo
(
    id    INT PRIMARY KEY AUTO_INCREMENT,
    ruolo VARCHAR(255) NOT NULL
);

-- Tabella: Categoria
CREATE TABLE Categoria
(
    id        INT PRIMARY KEY AUTO_INCREMENT,
    categoria VARCHAR(255) NOT NULL
);

-- Tabella: Recensione
CREATE TABLE Recensione
(
    id          INT PRIMARY KEY AUTO_INCREMENT,
    titolo      VARCHAR(255)  NOT NULL,
    descrizione TEXT,
    voto        DECIMAL(3, 1) NOT NULL CHECK (voto >= 1 AND voto <= 10),
    id_film     INT,
    id_serie    INT,
    id_utente   INT           NOT NULL,
    CONSTRAINT fk_recensione_serie FOREIGN KEY (id_serie) REFERENCES Serie (id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_recensione_film FOREIGN KEY (id_film) REFERENCES Film (id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_recensione_utente FOREIGN KEY (id_utente) REFERENCES Utenti (id) ON DELETE CASCADE ON UPDATE CASCADE
);

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


-- Tabella: Preferiti
CREATE TABLE Preferiti
(
    id        INT PRIMARY KEY AUTO_INCREMENT,
    id_serie  INT,
    id_film   INT,
    id_utente INT NOT NULL,
    CONSTRAINT fk_preferiti_serie FOREIGN KEY (id_serie) REFERENCES Serie (id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_preferiti_film FOREIGN KEY (id_film) REFERENCES Film (id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_preferiti_utente FOREIGN KEY (id_utente) REFERENCES Utenti (id) ON DELETE CASCADE ON UPDATE CASCADE
);

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

-- Tabella: Partecipa
CREATE TABLE Partecipa
(
    id             INT PRIMARY KEY AUTO_INCREMENT,
    id_personaggio INT NOT NULL,
    id_serie       INT,
    id_film        INT,
    ruolo          INT NOT NULL,
    interpreta     VARCHAR(255),
    CONSTRAINT fk_partecipa_personaggio FOREIGN KEY (id_personaggio) REFERENCES Personaggi (id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_partecipa_serie FOREIGN KEY (id_serie) REFERENCES Serie (id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_partecipa_film FOREIGN KEY (id_film) REFERENCES Film (id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_partecipa_ruolo FOREIGN KEY (ruolo) REFERENCES Ruolo (id) ON DELETE RESTRICT ON UPDATE CASCADE
);

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

-- Tabella: Caratterizza
CREATE TABLE Caratterizza
(
    id           INT PRIMARY KEY AUTO_INCREMENT,
    id_serie     INT,
    id_film      INT,
    id_categoria INT NOT NULL,
    CONSTRAINT fk_caratterizza_serie FOREIGN KEY (id_serie) REFERENCES Serie (id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_caratterizza_film FOREIGN KEY (id_film) REFERENCES Film (id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_caratterizza_categoria FOREIGN KEY (id_categoria) REFERENCES Categoria (id) ON DELETE RESTRICT ON UPDATE CASCADE
);

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
