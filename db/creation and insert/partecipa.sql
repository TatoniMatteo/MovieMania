create table partecipa
(
    id             int auto_increment
        primary key,
    id_personaggio int          not null,
    id_serie       int          null,
    id_film        int          null,
    ruolo          int          not null,
    interpreta     varchar(255) null,
    star           tinyint(1)   null,
    constraint fk_partecipa_film
        foreign key (id_film) references film (id)
            on update cascade,
    constraint fk_partecipa_personaggio
        foreign key (id_personaggio) references personaggi (id)
            on update cascade,
    constraint fk_partecipa_ruolo
        foreign key (ruolo) references ruolo (id)
            on update cascade,
    constraint fk_partecipa_serie
        foreign key (id_serie) references serie (id)
            on update cascade
);

INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (1, 1, null, 1, 2, 'Jack Dawson', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (2, 2, null, 1, 2, 'Rose DeWitt Bukater', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (3, 3, null, 2, 2, 'Frodo ', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (4, 4, null, 2, 1, null, 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (5, 5, 3, null, 2, 'Eleven', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (7, 7, null, 4, 2, 'Forrest Gump', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (8, 8, null, 4, 1, null, 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (9, 9, null, 4, 3, null, 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (10, 10, null, 4, 2, 'Jenny Curran', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (11, 11, null, 4, 4, null, 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (12, 12, null, 4, 2, 'Lieutenant Dan Taylor', 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (13, 13, null, 11, 2, 'Shazam', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (15, 14, null, 2, 2, 'Gandalf', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (16, 11, null, 13, 1, null, 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (17, 8, null, 13, 2, 'Fridge', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (18, 13, null, 13, 2, 'Spencer', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (19, 3, null, 13, 4, null, 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (40, 15, null, 14, 3, null, 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (41, 17, null, 14, 1, null, 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (42, 18, null, 14, 2, 'Tony Stark / Iron Man', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (43, 19, null, 14, 2, 'Steve Rogers / Captain America', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (44, 20, null, 14, 2, 'Bruce Banner / Hulk', 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (45, 21, null, 14, 2, 'Thor', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (46, 22, null, 14, 2, 'Natasha Romanoff / Black Widow', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (47, 23, null, 14, 2, 'Scott Lang / Ant-Man', 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (48, 24, null, 14, 2, 'Stephen Strange / Doctor Strange', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (49, 16, null, 14, 4, null, 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (56, 26, 4, null, 3, null, 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (57, 6, 4, null, 2, 'Rachel Green', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (58, 27, 4, null, 2, 'Monica Geller', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (59, 28, 4, null, 2, 'Phoebe Buffay', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (60, 29, 4, null, 2, 'Joey Tribbiani', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (61, 30, 4, null, 2, 'Chandler Bing', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (62, 31, 4, null, 2, 'Ross Geller', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (75, 11, null, 12, 1, null, 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (76, 13, null, 12, 2, 'Shazam', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (97, 34, 13, null, 3, null, 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (98, 32, 13, null, 2, 'Lord Anthony Bridgerton ', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (99, 33, 13, null, 2, 'Daphne Basset', 1);
