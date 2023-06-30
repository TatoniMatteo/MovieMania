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
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (6, 6, 4, null, 2, 'Rachel Green', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (7, 7, null, 4, 2, 'Forrest Gump', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (8, 8, null, 4, 1, null, 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (9, 9, null, 4, 3, null, 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (10, 10, null, 4, 2, 'Jenny Curran', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (11, 11, null, 4, 4, null, 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (12, 12, null, 4, 2, 'Lieutenant Dan Taylor', 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (13, 13, null, 11, 2, 'Shazam', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (14, 14, null, 2, 2, 'Gandalf', 1);
