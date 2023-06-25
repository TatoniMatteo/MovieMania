USE moviemania;

-- Inserimento dei film
INSERT INTO Film (titolo, data_pubblicazione, descrizione, trailer, durata)
VALUES ('Titanic', '1997-12-19',
        'Un grande transatlantico, il Titanic, in viaggio verso gli Stati Uniti, affonda nel 1912 dopo essersi scontrato con un iceberg.',
        'https://www.youtube.com/watch?v=kVrqfYjkTdQ', 194),
       ('Il Signore degli Anelli: La Compagnia dell\'Anello', '2001-12-19',
        'Un giovane hobbit di nome Frodo Baggins intraprende un pericoloso viaggio per distruggere un potente anello e salvare la Terra di Mezzo.',
        'https://www.youtube.com/watch?v=Pki6jbSbXIY', 178),
       ('Il Padrino', '1972-03-24',
        'La storia del potente padrino della mafia italo-americana, Don Vito Corleone, e della sua famiglia.',
        'https://www.youtube.com/watch?v=sY1S34973zA', 175),
       ('Forrest Gump', '1994-07-06', 'La vita straordinaria di Forrest Gump, un uomo semplice ma con un cuore grande.',
        'https://www.youtube.com/watch?v=uPIEn0M8su0', 142),
       ('Pulp Fiction', '1994-10-14',
        'Una serie di storie interconnesse che coinvolgono personaggi violenti, bizzarri e indimenticabili.',
        'https://www.youtube.com/watch?v=s7EdQ4FqbhY', 154),
       ('Inception', '2010-07-16',
        'Un esperto di furto di informazioni inserisce segretamente idee nella mente delle persone mentre dormono.',
        'https://www.youtube.com/watch?v=YoHD9XEInc0', 148),
       ('Schindler\'s List', '1993-11-30',
        'La storia vera di Oskar Schindler, un uomo d''affari tedesco che ha salvato la vita a oltre mille ebrei durante l''Olocausto.',
        'https://www.youtube.com/watch?v=gG22XNhtnoY', 195),
       ('Fight Club', '1999-09-21',
        'La storia di un uomo che si unisce a un club clandestino dove le persone combattono tra loro.',
        'https://www.youtube.com/watch?v=_XgQA9Ab0Gw', 139),
       ('Il Cavaliere Oscuro', '2008-07-18',
        'Batman affronta il suo più grande nemico, il Joker, in una lotta per il destino di Gotham City.',
        'https://www.youtube.com/watch?v=EXeTwQWrcwY', 152),
       ('Il Gladiatore', '2000-05-05',
        'La storia di un generale romano che viene ridotto in schiavitù e diventa un gladiatore in cerca di vendetta.',
        'https://www.youtube.com/watch?v=owK1qxDselE', 155);

-- Inserimento delle serie
INSERT INTO Serie (titolo, descrizione, trailer, conclusa)
VALUES ('Breaking Bad',
        'La trasformazione di un insegnante di chimica, Walter White, in un pericoloso produttore di metanfetamine.',
        'https://www.youtube.com/watch?v=HhesaQXLuRY', 1),
       ('Game of Thrones',
        'La lotta per il trono di Westeros tra nobili famiglie in un mondo fantastico pieno di intrighi, battaglie e tradimenti.',
        'https://www.youtube.com/watch?v=rlR4PJn8b8I', 1),
       ('Stranger Things',
        'Una serie di misteri e avventure ambientata negli anni ''80, con un gruppo di ragazzi che si imbatte in fenomeni soprannaturali.',
        'https://www.youtube.com/watch?v=XWxyRG_tckY', 0),
       ('Friends', 'Le vicende di un gruppo di amici che vivono a New York, affrontando amori, lavoro e molte risate.',
        'https://www.youtube.com/watch?v=m4L6RU4eDC8', 1),
       ('Breaking Bad',
        'La trasformazione di un insegnante di chimica, Walter White, in un pericoloso produttore di metanfetamine.',
        'https://www.youtube.com/watch?v=HhesaQXLuRY', 1);

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
VALUES ('Ottimo film', 'Mi è piaciuto molto questo film. La trama è avvincente e gli attori sono fantastici.', 8.5, 1,
        NULL, 1),
       ('Deludente',
        'Mi aspettavo di più da questo film. La storia è poco originale e gli effetti speciali sono mediocri.', 5.2, 1,
        NULL, 2),
       ('Da non perdere', 'Questa serie è semplicemente fantastica. Ogni episodio tiene incollato allo schermo.', 9.3,
        NULL, 1, 3),
       ('Un capolavoro',
        'Ho amato ogni singola stagione di questa serie. È un mix perfetto di azione, suspense e intrighi.', 9.8, NULL,
        1, 4),
       ('Consigliato', 'Un film commovente e ben interpretato. Ha saputo catturare le emozioni dello spettatore.', 8.1,
        2, NULL, 2),
       ('Non all\'altezza delle aspettative',
        'Mi aspettavo di più da questa serie. La trama è un po'' scontata e i personaggi poco sviluppati.', 6.4, NULL,
        2, 3),
       ('Un capolavoro',
        'La migliore serie che abbia mai visto. Non vedo l''ora di scoprire cosa succederà nella prossima stagione.',
        9.9, NULL, 2, 1),
       ('Film divertente', 'Una commedia leggera e divertente. Perfetta per una serata di relax.', 7.6, 3, NULL, 4),
       ('Suspense al massimo',
        'Questa serie mi ha tenuto col fiato sospeso fino all''ultima puntata. Consigliatissima!', 9.5, NULL, 3, 1),
       ('Superbo', 'Un film che ti cattura fin dal primo minuto. Grandi interpretazioni e una storia coinvolgente.',
        9.2, 4, NULL, 2),
       ('Da rivedere', 'Una delle migliori serie di sempre. Ha saputo trattare tematiche complesse in modo brillante.',
        9.7, NULL, 4, 1),
       ('Non mi è piaciuto',
        'Questo film non è riuscito a coinvolgermi. La trama è confusa e gli attori poco convincenti.', 4.8, 5, NULL,
        2),
       ('Serie eccezionale', 'Ho apprezzato molto questa serie. Personaggi ben sviluppati e una trama avvincente.', 9.4,
        NULL, 1, 2),
       ('Un film toccante', 'Questa pellicola mi ha emozionato profondamente. Gli attori hanno dato il massimo.', 8.9,
        6, NULL, 4),
       ('Delusione totale',
        'Mi aspettavo molto di più da questa serie. La storia è banale e i personaggi poco interessanti.', 5.1, NULL, 2,
        4),
       ('Assolutamente da vedere',
        'Una delle migliori serie degli ultimi anni. Non potrete fare a meno di innamorarvi dei personaggi.', 9.6, NULL,
        3, 4),
       ('Film divertente', 'Una commedia leggera e piacevole. Perfetta per una serata di svago con gli amici.', 7.8, 7,
        NULL, 3),
       ('Intrigante e misteriosa',
        'Questa serie mi ha catturato fin dall''inizio. Ogni episodio ti lascia con il desiderio di scoprire di più.',
        9.1, NULL, 4, 4),
       ('Capolavoro assoluto',
        'Un film che rimarrà nella storia. Interpretazioni straordinarie e una trama avvincente.', 9.9, 8, NULL, 2),
       ('Una serie indimenticabile',
        'Ho seguito questa serie per anni e non potrei essere più soddisfatto del suo finale.', 9.8, NULL, 5, 1);


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
INSERT INTO Categoria (categoria, colore)
VALUES ('Azione', 'red'),
       ('Commedia', 'yellow'),
       ('Drammatico', 'blue'),
       ('Horror', 'purple'),
       ('Fantascienza', 'teal'),
       ('Avventura', 'olive'),
       ('Romantico', 'pink'),
       ('Thriller', 'maroon'),
       ('Animazione', 'green'),
       ('Crime', 'gray'),
       ('Fantasy', 'indigo'),
       ('Documentario', 'brown'),
       ('Musical', 'orchid'),
       ('Guerra', 'navy'),
       ('Supereroi', 'gold'),
       ('Western', 'lime'),
       ('Suspense', 'red'),
       ('Biografico', 'purple'),
       ('Storico', 'green'),
       ('Sportivo', 'yellow');

-- Inserimento delle relazioni Caratterizza
INSERT INTO Caratterizza (id_film, id_serie, id_categoria)
VALUES (1, NULL, 3),
       (1, NULL, 7),
       (2, NULL, 6),
       (2, NULL, 1),
       (3, NULL, 10),
       (3, NULL, 3),
       (4, NULL, 3),
       (4, NULL, 2),
       (5, NULL, 10),
       (5, NULL, 8),
       (6, NULL, 5),
       (6, NULL, 8),
       (7, NULL, 18),
       (7, NULL, 19),
       (8, NULL, 3),
       (8, NULL, 8),
       (9, NULL, 1),
       (9, NULL, 10),
       (10, NULL, 1),
       (10, NULL, 19),
       (NULL, 1, 10),
       (NULL, 1, 3),
       (NULL, 2, 6),
       (NULL, 2, 11),
       (NULL, 3, 6),
       (NULL, 3, 11),
       (NULL, 4, 2),
       (NULL, 4, 3),
       (NULL, 5, 3),
       (NULL, 5, 10);

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

