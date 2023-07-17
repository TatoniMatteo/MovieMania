create table possiede
(
    id          int auto_increment
        primary key,
    utente_id   int not null,
    permesso_id int not null,
    constraint possiede_ibfk_1
        foreign key (utente_id) references utenti (id),
    constraint possiede_ibfk_2
        foreign key (permesso_id) references permessi (id)
);

create index permesso_id
    on possiede (permesso_id);

create index utente_id
    on possiede (utente_id);

INSERT INTO moviemania.possiede (id, utente_id, permesso_id) VALUES (1, 1, 1);
INSERT INTO moviemania.possiede (id, utente_id, permesso_id) VALUES (2, 2, 1);
INSERT INTO moviemania.possiede (id, utente_id, permesso_id) VALUES (3, 3, 1);
INSERT INTO moviemania.possiede (id, utente_id, permesso_id) VALUES (4, 4, 1);
INSERT INTO moviemania.possiede (id, utente_id, permesso_id) VALUES (5, 5, 1);
INSERT INTO moviemania.possiede (id, utente_id, permesso_id) VALUES (6, 5, 2);
INSERT INTO moviemania.possiede (id, utente_id, permesso_id) VALUES (7, 5, 3);
INSERT INTO moviemania.possiede (id, utente_id, permesso_id) VALUES (36, 1, 3);
INSERT INTO moviemania.possiede (id, utente_id, permesso_id) VALUES (37, 6, 1);
INSERT INTO moviemania.possiede (id, utente_id, permesso_id) VALUES (38, 7, 1);
INSERT INTO moviemania.possiede (id, utente_id, permesso_id) VALUES (39, 8, 1);
