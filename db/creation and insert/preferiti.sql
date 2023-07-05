create table preferiti
(
    id        int auto_increment
        primary key,
    id_serie  int null,
    id_film   int null,
    id_utente int not null,
    constraint fk_preferiti_film
        foreign key (id_film) references film (id)
            on update cascade,
    constraint fk_preferiti_serie
        foreign key (id_serie) references serie (id)
            on update cascade,
    constraint fk_preferiti_utente
        foreign key (id_utente) references utenti (id)
            on update cascade on delete cascade
);

INSERT INTO moviemania.preferiti (id, id_serie, id_film, id_utente) VALUES (1, 1, null, 1);
INSERT INTO moviemania.preferiti (id, id_serie, id_film, id_utente) VALUES (2, null, 3, 1);
INSERT INTO moviemania.preferiti (id, id_serie, id_film, id_utente) VALUES (3, 2, null, 2);
INSERT INTO moviemania.preferiti (id, id_serie, id_film, id_utente) VALUES (4, null, 5, 2);
INSERT INTO moviemania.preferiti (id, id_serie, id_film, id_utente) VALUES (5, 3, null, 3);
INSERT INTO moviemania.preferiti (id, id_serie, id_film, id_utente) VALUES (6, null, 4, 3);
INSERT INTO moviemania.preferiti (id, id_serie, id_film, id_utente) VALUES (7, 4, null, 4);
INSERT INTO moviemania.preferiti (id, id_serie, id_film, id_utente) VALUES (8, null, 1, 4);
INSERT INTO moviemania.preferiti (id, id_serie, id_film, id_utente) VALUES (12, null, 2, 6);
