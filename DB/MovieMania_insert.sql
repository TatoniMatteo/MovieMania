USE moviemania;

-- Inserimento dei film
INSERT INTO Film (titolo, data_pubblicazione, descrizione, trailer, durata, copertina)
VALUES ('Titanic', '1997-12-19',
        'Un grande transatlantico, il Titanic, in viaggio verso gli Stati Uniti, affonda nel 1912 dopo essersi scontrato con un iceberg.',
        'https://www.youtube.com/watch?v=kVrqfYjkTdQ', 194, 'copertina.jpg'),
       ('Il Signore degli Anelli: La Compagnia dell''Anello', '2001-12-19',
        'Un giovane hobbit di nome Frodo Baggins intraprende un pericoloso viaggio per distruggere un potente anello e salvare la Terra di Mezzo.',
        'https://www.youtube.com/watch?v=Pki6jbSbXIY', 178, 'copertina.jpg'),
       ('Il Padrino', '1972-03-24',
        'La storia del potente padrino della mafia italo-americana, Don Vito Corleone, e della sua famiglia.',
        'https://www.youtube.com/watch?v=sY1S34973zA', 175, 'copertina.jpg'),
       ('Forrest Gump', '1994-07-06', 'La vita straordinaria di Forrest Gump, un uomo semplice ma con un cuore grande.',
        'https://www.youtube.com/watch?v=uPIEn0M8su0', 142, 'copertina.jpg'),
       ('Pulp Fiction', '1994-10-14',
        'Una serie di storie interconnesse che coinvolgono personaggi violenti, bizzarri e indimenticabili.',
        'https://www.youtube.com/watch?v=s7EdQ4FqbhY', 154, 'copertina.jpg'),
       ('Inception', '2010-07-16',
        'Un esperto di furto di informazioni inserisce segretamente idee nella mente delle persone mentre dormono.',
        'https://www.youtube.com/watch?v=YoHD9XEInc0', 148, 'copertina.jpg'),
       ('Schindler''s List', '1993-11-30',
        'La storia vera di Oskar Schindler, un uomo d''affari tedesco che ha salvato la vita a oltre mille ebrei durante l''Olocausto.',
        'https://www.youtube.com/watch?v=gG22XNhtnoY', 195, 'copertina.jpg'),
       ('Fight Club', '1999-09-21',
        'La storia di un uomo che si unisce a un club clandestino dove le persone combattono tra loro.',
        'https://www.youtube.com/watch?v=_XgQA9Ab0Gw', 139, 'copertina.jpg'),
       ('Il Cavaliere Oscuro', '2008-07-18',
        'Batman affronta il suo più grande nemico, il Joker, in una lotta per il destino di Gotham City.',
        'https://www.youtube.com/watch?v=EXeTwQWrcwY', 152, 'copertina.jpg'),
       ('Il Gladiatore', '2000-05-05',
        'La storia di un generale romano che viene ridotto in schiavitù e diventa un gladiatore in cerca di vendetta.',
        'https://www.youtube.com/watch?v=owK1qxDselE', 155, 'copertina.jpg');

-- Inserimento delle serie
INSERT INTO Serie (titolo, descrizione, trailer, conclusa, copertina)
VALUES ('Breaking Bad',
        'La trasformazione di un insegnante di chimica, Walter White, in un pericoloso produttore di metanfetamine.',
        'https://www.youtube.com/watch?v=HhesaQXLuRY', 1, 'copertina.jpg'),
       ('Game of Thrones',
        'La lotta per il trono di Westeros tra nobili famiglie in un mondo fantastico pieno di intrighi, battaglie e tradimenti.',
        'https://www.youtube.com/watch?v=rlR4PJn8b8I', 1, 'copertina.jpg'),
       ('Stranger Things',
        'Una serie di misteri e avventure ambientata negli anni ''80, con un gruppo di ragazzi che si imbatte in fenomeni soprannaturali.',
        'https://www.youtube.com/watch?v=XWxyRG_tckY', 0, 'copertina.jpg'),
       ('Friends', 'Le vicende di un gruppo di amici che vivono a New York, affrontando amori, lavoro e molte risate.',
        'https://www.youtube.com/watch?v=m4L6RU4eDC8', 1, 'copertina.jpg'),
       ('Breaking Bad',
        'La trasformazione di un insegnante di chimica, Walter White, in un pericoloso produttore di metanfetamine.',
        'https://www.youtube.com/watch?v=HhesaQXLuRY', 1, 'copertina.jpg');

-- Inserimento degli utenti
INSERT INTO Utenti (nome, cognome, username, email, password)
VALUES ('Mario', 'Rossi', 'mario89', 'mario89@email.com', 'password1'),
       ('Luca', 'Bianchi', 'luca92', 'luca92@email.com', 'password2'),
       ('Laura', 'Verdi', 'laura87', 'laura87@email.com', 'password3'),
       ('Roberto', 'Neri', 'roby83', 'roby83@email.com', 'password4');

-- Inserimento delle relazioni Preferiti
INSERT INTO Preferiti (id_serie, id_film, id_utente)
VALUES (1, NULL, 1),
       (NULL, 3, 1),
       (2, NULL, 2),
       (NULL, 5, 2),
       (3, NULL, 3),
       (NULL, 4, 3),
       (4, NULL, 4),
       (NULL, 1, 4);

-- Inserimento delle recensioni
INSERT INTO Recensione (titolo, descrizione, voto, id_film, id_serie, id_utente)
VALUES ('Un film eccezionale', 'Ho adorato questo film! La storia è avvincente e gli attori sono fantastici.', 9.5, 1,
        NULL, 1),
       ('Capolavoro assoluto',
        'Non ho parole per descrivere quanto mi sia piaciuto questo film. Da vedere assolutamente!', 10, 2, NULL, 2),
       ('Molto divertente', 'Una commedia leggera ma molto divertente. Consigliata per una serata di relax.', 8, 4,
        NULL, 3),
       ('Emozionante', 'Questo film mi ha emozionato profondamente. Un capolavoro di regia e interpretazione.', 9, 7,
        NULL, 4);

-- Inserimento dei personaggi
INSERT INTO Personaggi (nome, cognome, data_nascita, nazionalita, altezza, biografia)
VALUES ('Leonardo', 'DiCaprio', '1974-11-11', 'USA', 1.83,
        'Leonardo DiCaprio è uno degli attori più acclamati e talentuosi della sua generazione. Ha recitato in numerosi film di successo, tra cui Titanic, Inception e The Wolf of Wall Street.'),
       ('Scarlett', 'Johansson', '1984-11-22', 'USA', 1.60,
        'Scarlett Johansson è una famosa attrice che ha recitato in molti film di successo, tra cui Lost in Translation, Avengers e Marriage Story.'),
       ('Robert', 'Downey Jr.', '1965-04-04', 'USA', 1.74,
        'Robert Downey Jr. è un attore molto talentuoso e versatile. È noto per il suo ruolo di Iron Man nei film del Marvel Cinematic Universe.'),
       ('Bryan', 'Cranston', '1956-03-07', 'USA', 1.79,
        'Bryan Cranston è un attore pluripremiato, famoso per il suo ruolo di Walter White nella serie Breaking Bad.'),
       ('Millie', 'Bobby Brown', '2004-02-19', 'Regno Unito', 1.63,
        'Millie Bobby Brown è una giovane attrice britannica. È diventata famosa per il suo ruolo di Eleven nella serie Stranger Things.'),
       ('Jennifer', 'Aniston', '1969-02-11', 'USA', 1.64,
        'Jennifer Aniston è un''attrice molto popolare grazie al suo ruolo di Rachel nella serie Friends.');

-- Inserimento dei ruoli
INSERT INTO Ruolo (ruolo)
VALUES ('Regista'),
       ('Attore'),
       ('Sceneggiatore');

-- Inserimento delle relazioni Partecipa
INSERT INTO Partecipa (id_personaggio, id_serie, id_film, ruolo, interpreta)
VALUES (1, NULL, 1, 1, NULL),
       (2, NULL, 1, 2, 'Rose'),
       (3, NULL, 2, 2, 'Tony Stark / Iron Man'),
       (4, NULL, 2, 1, NULL),
       (5, 3, NULL, 2, 'Eleven'),
       (6, 3, NULL, 2, 'Rachel Green');

-- Inserimento delle categorie
INSERT INTO Categoria (categoria)
VALUES ('Azione'),
       ('Commedia'),
       ('Drammatico'),
       ('Fantascienza'),
       ('Thriller');

-- Inserimento delle relazioni Caratterizza
INSERT INTO Caratterizza (id_serie, id_film, id_categoria)
VALUES (1, NULL, 1),
       (1, NULL, 3),
       (2, NULL, 4),
       (2, NULL, 2),
       (3, NULL, 4),
       (3, NULL, 3),
       (4, NULL, 2),
       (4, NULL, 5),
       (NULL, 1, 3),
       (NULL, 1, 4),
       (NULL, 2, 1),
       (NULL, 2, 3),
       (NULL, 3, 2),
       (NULL, 3, 4),
       (NULL, 4, 1),
       (NULL, 4, 5);

-- Inserimento delle stagioni
INSERT INTO Stagione (data_pubblicazione, copertina, id_serie, numero_stagione)
VALUES ('2020-01-01', 'copertina.jpg', 1, 1),
       ('2021-03-15', 'copertina.jpg', 1, 2),
       ('2019-06-30', 'copertina.jpg', 2, 1),
       ('2020-02-14', 'copertina.jpg', 2, 2),
       ('2021-07-05', 'copertina.jpg', 2, 3),
       ('2018-09-10', 'copertina.jpg', 3, 1),
       ('2019-01-15', 'copertina.jpg', 3, 2),
       ('2020-05-20', 'copertina.jpg', 4, 1),
       ('2021-09-01', 'copertina.jpg', 4, 2),
       ('2022-03-10', 'copertina.jpg', 4, 3),
       ('2017-01-20', 'copertina.jpg', 5, 1),
       ('2019-05-04', 'copertina.jpg', 5, 2),
       ('2022-03-18', 'copertina.jpg', 5, 3);

