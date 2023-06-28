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

INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (1, 1, null, 1, 1, null, 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (2, 2, null, 1, 2, 'Rose', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (3, 3, null, 2, 2, 'Tony Stark / Iron Man', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (4, 4, null, 2, 1, null, 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (5, 5, 3, null, 2, 'Eleven', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (6, 6, 4, null, 2, 'Rachel Green', 1);
